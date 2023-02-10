<template>
  <v-container>
    <v-btn color="teal accent-4" @click="navigateTo('home')"> Back </v-btn>
    <h1 class="text-h2 text-center mb-10">Forums</h1>
    <div>
      <v-row class="mb-6" no-gutters align-content="space-evenly">
        <v-col v-for="forum in forums" :key="forum.id" :cols="cols">
          <CardForum :forum="forum"></CardForum>
        </v-col>
      </v-row>
    </div>
  </v-container>
</template>
<script>
import { mapGetters } from "vuex";
import CardForum from "../components/CardForum.vue";

export default {
  components: { CardForum },
  data() {
    return {
      forums: [],
    };
  },
  mounted() {
    this.$store.dispatch("getValidForums").then(() => {
      this.forums = this.getForums;
    });
  },
  methods: {
    navigateTo(route) {
      this.$router.push({ name: route });
    },
  },
  computed: {
    ...mapGetters(["getForums"]),
    cols() {
      let col = 12;
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
};
</script>
