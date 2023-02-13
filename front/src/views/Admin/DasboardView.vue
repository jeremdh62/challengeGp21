<template>
  <v-container>
    <v-btn color="teal accent-4" @click="navigateTo('home')">
      Return Home
    </v-btn>
    <h1 class="text-h3 text-center">Dashboard</h1>

    <v-card class="mx-auto" width="900">
      <v-list>
        <v-list-item
          prepend-icon="mdi-newspaper"
          append-icon="mdi-chevron-right"
          title="Articles"
          @click="navigateTo('admin-articles')"
        ></v-list-item>
        <v-list-item
          prepend-icon="mdi-forum"
          append-icon="mdi-chevron-right"
          title="Forums"
          @click="navigateTo('admin-forums')"
        ></v-list-item>
      </v-list>
    </v-card>
  </v-container>
</template>
<script>
export default {
  data: () => ({}),
  methods: {
    navigateTo(route) {
      this.$router.push({ name: route });
    },
  },
};
</script>
