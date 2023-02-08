<template>
  <v-container>
    <v-form>
      <v-text-field
        label="Title"
        v-model="article.title"
        required
      ></v-text-field>
      <QuillEditor
        contentType="html"
        v-model:content="article.content"
        toolbar="full"
        theme="snow"
      />
      <div class="d-flex flex-column">
        <v-btn color="success" class="mt-4" @click="validate" block>
          Validate
        </v-btn>
        <v-btn
          color="error"
          class="mt-4"
          @click="navigate('admin-articles')"
          block
        >
          Cancel
        </v-btn>
      </div>
    </v-form>
  </v-container>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    article: {
      title: "",
      content: "",
    },
  }),
  mounted() {
    let requestArticles = this.$store.dispatch("getAllArticles");

    requestArticles.then(() => {
      this.article = this.getArticles.find(
        (article) => article.id == this.$route.params.id
      );
    });
  },
  computed: {
    ...mapGetters(["getArticles"]),
  },
  methods: {
    navigate(route) {
      this.$router.push({ name: route });
    },
    validate() {
      this.$store.dispatch("updateArticle", this.article).then(() => {
        this.navigate("admin-articles");
      });
    },
  },
};
</script>
