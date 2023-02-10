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
    </v-card>
  </v-container>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    forum: {},
  }),
  mounted() {
    this.$store.dispatch("getAllForums");
    this.forum = this.getForums.find(
      (forum) => forum.id == this.$route.params.id
    );
  },
  computed: {
    ...mapGetters(["getForums"]),
  },
  methods: {
    navigate(route) {
      this.$router.push({ name: route });
    },
    back() {
      this.$router.go(-1);
    },
  },
};
</script>
