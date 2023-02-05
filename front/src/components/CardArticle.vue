<template>
  <v-row>
    <v-col v-for="article in getArticles" :key="article.id">
      <v-card class="mx-auto" max-width="344">
        <v-img src="img/nba2k_tuto.jpg" height="150px" cover></v-img>

        <v-card-title> {{ article.title }} </v-card-title>

        <v-card-subtitle> 1,000 miles of wonder </v-card-subtitle>

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
  },
  methods: {
    linkArticle(route, id) {
      this.$router.push({ name: route, params: { id: id } });
    },
  },
};
</script>
