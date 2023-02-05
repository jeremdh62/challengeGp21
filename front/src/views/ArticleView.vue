<template>
  <div>
    <h1>{{ getArticle.title }}</h1>
    <p>{{ getArticle.content }}</p>
  </div>
</template>
<script>
export default {
  data: () => ({
    article: {},
  }),
  mounted() {
    this.article = this.$store.dispatch(
      "getArticleInfo",
      this.$route.params.id
    );

    console.log(this.article);
  },
  computed: {},
  methods: {},
};
</script>
