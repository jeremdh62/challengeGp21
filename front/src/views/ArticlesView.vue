<template>
  <v-container>
    <v-btn color="teal accent-4" @click="navigateTo('home')"> Back </v-btn>
    <h1 class="text-h2 text-center mb-10">Articles</h1>
    <div>
      <v-row class="mb-6" no-gutters align-content="space-evenly">
        <v-col v-for="article in getArticles" :key="article.id" :cols="cols">
          <CardArticle :article="article"></CardArticle>
        </v-col>
      </v-row>
    </div>
  </v-container>
</template>
<script>
import CardArticle from "../components/CardArticle.vue";
import { mapGetters } from "vuex";

export default {
  components: { CardArticle },
  mounted() {
    this.$store.dispatch("getAllArticles");
  },
  methods: {
    navigateTo(route) {
      this.$router.push({ name: route });
    },
  },
  computed: {
    ...mapGetters(["getArticles"]),
    cols() {
      let col = 12;
      switch (this.$vuetify.display.name) {
        case "xs":
          col = 12;
          break;
        case "sm":
          col = 9;
          break;
        case "md":
          col = 6;
          break;
        case "lg":
          col = 4;
          break;
        case "xl":
          col = 3;
          break;
      }

      return col;
    },
  },
};
</script>
