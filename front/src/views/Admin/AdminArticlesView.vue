<template>
  <v-container>
    <v-table>
      <thead>
        <tr>
          <th class="text-left">Title</th>
          <th class="text-left">Created At</th>
          <th class="text-left">Created By</th>
          <th class="text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="article in getArticles" :key="article.id">
          <td>{{ article.title }}</td>
          <td>{{ article.createdAt }}</td>
          <td>{{ article.createdBy }}</td>
          <td>
            <v-btn
              color="primary"
              @click="linkArticle('admin-article-edit', article.id)"
              >Edit</v-btn
            >
            <v-btn color="error">Delete</v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
  </v-container>
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