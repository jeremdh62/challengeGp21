<script setup>
import { RouterView } from "vue-router"; // <--- import RouterLink
import NavBar from "./components/NavBar.vue";
</script>

<template>
  <v-app>
    <v-layout>
      <NavBar />
      <v-main>
        <RouterView />
      </v-main>
    </v-layout>
  </v-app>
</template>
