<template>
  <div>
    <v-btn text color="teal accent-4" @click="navigate('articles')">
      Back
    </v-btn>
    <v-card variant="tonal">
      <v-card-title>
        <div>
          <h3 class="headline mb-0">{{ article.title }}</h3>
          <div>{{ article.author }}</div>
        </div>
      </v-card-title>
      <v-card-text>
        <div v-html="article.content"></div>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({
    article: {},
  }),
  mounted() {
    this.$store.dispatch("getAllArticles");
    this.article = this.getArticles.find(
      (article) => article.id == this.$route.params.id
    );
  },
  computed: {
    ...mapGetters(["getArticles"]),
  },
  methods: {
    navigate(route) {
      this.$router.push({ name: route });
    },
  },
};
</script>
