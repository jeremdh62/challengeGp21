<template>
  <v-row class="mb-6" no-gutters align-content="space-evenly">
    <v-col v-for="article in getArticles" :key="article.id" :cols="cols">
      <v-card max-width="344" class="mb-10">
        <v-img src="img/nba2k_tuto.jpg" height="150px" cover></v-img>

        <v-card-title> {{ article.title }} </v-card-title>

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
    </v-col>
  </v-row>
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
    cols() {
      let col = 12;
      console.log(this.$vuetify.display.name);
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
  methods: {
    linkArticle(route, id) {
      this.$router.push({ name: route, params: { id: id } });
    },
  },
};
</script>
