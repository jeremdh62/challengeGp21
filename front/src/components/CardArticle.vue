<template>
  <v-card width="344" class="mb-10">
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
</template>

<script>
export default {
  props: {
    article: {
      type: Object,
      required: true,
    },
  },
  data: () => ({}),
  methods: {
    linkArticle(route, id) {
      this.$router.push({ name: route, params: { id: id } });
    },
  },
};
</script>
