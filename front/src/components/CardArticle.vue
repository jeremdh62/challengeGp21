<template>
  <div v-for="article in getArticles" :key="article.id">
    <v-card class="mx-auto" max-width="344">
      <v-card-text>
        <p class="text-h4 text--primary">{{ article.title }}</p>
      </v-card-text>
      <v-card-actions>
        <v-btn
          text
          color="teal accent-4"
          @click="linkArticle('article', article.id)"
        >
          Learn More
        </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data: () => ({}),
  mounted() {
    this.$store.dispatch("getAllArticles");
  },

  computed: {
    ...mapGetters(["getArticles"]),
  },
  methods: {
    linkArticle(route, id) {
      this.$router.push({ name: route, params: { id: id } });
    },
  },
};
</script>
