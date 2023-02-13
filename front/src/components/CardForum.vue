<template>
  <v-card width="344" class="mb-10">
    <v-card-title> {{ forum.title }} </v-card-title>
    <v-card-actions>
      <v-btn text color="teal accent-4" @click="linkForum('forum', forum.id)">
        Learn More
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: {
    forum: {
      type: Object,
      required: true,
    },
  },
  data: () => ({}),
  methods: {
    linkForum(route, id) {
      this.$router.push({ name: route, params: { id: id } });
    },
  },
};
</script>
