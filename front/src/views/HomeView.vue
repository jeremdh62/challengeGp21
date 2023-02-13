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
    <div v-if="this.articles.length > 0">
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
    </div>
    <div v-if="this.forums.length > 0">
      <SliderItem
        title="New forums"
        :items="getForumsOrder()"
        linkMore="forums"
      >
        <template v-slot:sliderContent="{ item, selectedClass }">
          <CardForum :class="['ma-4', selectedClass]" :forum="item"></CardForum>
        </template>
      </SliderItem>
    </div>
  </v-container>
</template>

<script>
import CardArticle from "../components/CardArticle.vue";
import CardForum from "../components/CardForum.vue";
import SliderItem from "../components/SliderItem.vue";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      articles: [],
      forums: [],
    };
  },
  components: { CardArticle, SliderItem, CardForum },
  mounted() {
    this.$store.dispatch("getAllArticles").then(() => {
      this.articles = this.getArticles;
    });
    this.$store.dispatch("getValidForums").then(() => {
      this.forums = this.getForums;
    });
  },
  computed: {
    ...mapGetters(["getArticles", "getForums"]),
  },
  methods: {
    getArticlesOrder() {
      const articlesSorted = this.articles.sort((a, b) => {
        return new Date(b.createdAt) - new Date(a.createdAt);
      });

      return articlesSorted.slice(0, 10);
    },
    getForumsOrder() {
      if (this.forums.length > 0) {
        const forumsSorted = this.forums.sort((a, b) => {
          return new Date(b.createdAt) - new Date(a.createdAt);
        });

        return forumsSorted.slice(0, 10);
      }
    },
    navigate(route) {
      this.$router.push({ name: route });
    },
  },
};
</script>
