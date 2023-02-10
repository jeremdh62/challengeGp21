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
    <SliderItem
      title="New articles"
      :items="getArticlesOrder()"
      linkMore="articles"
    >
      <template v-slot:sliderContent="{ item, selectedClass }">
        <CardArticle
          :class="['ma-4', selectedClass]"
          :article="item"
        ></CardArticle>
      </template>
    </SliderItem>
  </v-container>
</template>

<script>
import CardArticle from "../components/CardArticle.vue";
import SliderItem from "../components/SliderItem.vue";
import { mapGetters } from "vuex";

export default {
  components: { CardArticle, SliderItem },
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
