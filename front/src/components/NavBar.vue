<template>
  <v-app-bar color="primary" density="compact">
    <v-app-bar-nav-icon
      variant="text"
      @click.stop="drawer = !drawer"
    ></v-app-bar-nav-icon>

    <v-app-bar-title @click="navigateTo('home')">App</v-app-bar-title>

    <v-spacer></v-spacer>

    <!-- TODO: check if user is connect display login / logout -->
    <v-btn icon @click="navigateTo('login')">
      <v-icon>mdi-account-circle</v-icon>
    </v-btn>
  </v-app-bar>

  <v-navigation-drawer v-model="drawer" temporary>
    <v-list density="compact" nav>
      <v-list-item
        prepend-icon="mdi-home"
        title="Home"
        value="home"
        @click="navigateTo('home')"
      >
      </v-list-item>
      <v-list-item
        prepend-icon="mdi-newspaper"
        title="Aticles"
        value="articles"
        @click="navigateTo('articles')"
      >
      </v-list-item>
      <v-list-item
        prepend-icon="mdi-forum"
        title="Forums"
        value="forums"
        @click="navigateTo('forums')"
      >
      </v-list-item>
      <!-- TODO: verify if user is admin -->
      <v-list-item
        prepend-icon="mdi-monitor-dashboard"
        title="admin"
        value="admin"
        @click="navigateTo('admin')"
      >
      </v-list-item>
      <!-- END TODO: verify if user is admin -->
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  data: () => ({
    drawer: false,
  }),
  methods: {
    navigateTo(route) {
      this.$router.push({ name: route });
    },
    logout() {
      this.$store.dispatch("logout");
    },
  },
};
</script>
