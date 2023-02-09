<template>
  <v-parallax src="img/nba2k.jpg" scale="1" height="400">
    <div
      class="d-flex flex-column fill-height justify-center align-center text-white"
    >
      <h1 class="text-h4 font-weight-thin mb-4">WE Ballin'</h1>
      <h4 class="subheading">Welcome</h4>
    </div>
  </v-parallax>
  <v-container>
    <v-sheet class="mx-auto justify-center" elevation="8" max-width="1300">
      <h5 class="text-h5 pt-5 text-center">New articles</h5>
      <v-slide-group class="pa-4" selected-class="bg-success" show-arrows>
        <v-slide-group-item
          v-for="article in getArticlesOrder()"
          :key="article.id"
          v-slot="{ selectedClass }"
        >
          <CardArticle
            :article="article"
            :class="['ma-4', selectedClass]"
          ></CardArticle>
        </v-slide-group-item>
      </v-slide-group>
      <div class="d-flex justify-center mb-6 pb-5">
        <v-btn color="success" @click="navigate('articles')">View More</v-btn>
      </div>
    </v-sheet>
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
  computed: {
    ...mapGetters(["getArticles"]),
  },
  methods: {
    getArticlesOrder() {
      const articles = this.getArticles.sort((a, b) => {
        return new Date(b.createdAt) - new Date(a.createdAt);
      });

      return articles.slice(0, 10);
    },
    navigate(route) {
      this.$router.push({ name: route });
    },
  },
};
</script>
