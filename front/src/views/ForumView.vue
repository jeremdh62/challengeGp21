<template>
  <v-container>
    <v-btn text color="teal accent-4 mb-5" @click="back()"> Back </v-btn>
    <v-card class="text-center">
      <v-card-title>
        <div>
          <h3 class="text-h3 mb-0">{{ forum.title }}</h3>
          <div>{{ forum.author }}</div>
          <v-divider></v-divider>
        </div>
      </v-card-title>
      <v-card-text>
        <div v-html="forum.content"></div>
      </v-card-text>

      <h5 class="text-h5 text-left ml-5 mb-5">Comments</h5>
      <v-textarea v-model="comment" label="Add a comment"></v-textarea>
      <v-btn rounded="lg" @click="createComment()" color="success">
        Send comment
      </v-btn>
      <div v-if="comments.length > 0">
        <v-list
          v-for="comment in comments"
          :key="comment.id"
          lines="three"
          class="text-left"
        >
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                {{ comment.createdBy.username }}</v-list-item-title
              >
              <v-list-item-subtitle>
                {{ comment.content }}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
        </v-list>
      </div>
    </v-card>
  </v-container>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    forum: {
      title: "",
      content: "",
    },
    comments: [],
    comment: "",
  }),
  mounted() {
    this.$store.dispatch("getAllForums").then(() => {
      this.forum = this.getForums.find(
        (forum) => forum.id == this.$route.params.id
      );
    });
    this.$store.dispatch("getAllComments", this.$route.params.id).then(() => {
      this.comments = this.getComments;
    });
  },
  computed: {
    ...mapGetters(["getForums", "getComments"]),
  },
  methods: {
    navigate(route) {
      this.$router.push({ name: route });
    },
    back() {
      this.$router.go(-1);
    },
    createComment() {
      this.$store.dispatch("createComment", {
        content: this.comment,
        forum: "/forums/" + this.$route.params.id,
      });
    },
  },
};
</script>
