<template>
  <v-sheet class="mx-auto justify-center" elevation="8" max-width="1300">
    <h5 class="text-h5 pt-5 text-center">{{ title }}</h5>
    <v-slide-group class="pa-4" selected-class="bg-success" show-arrows>
      <v-slide-group-item
        v-for="item in items"
        :key="item.id"
        v-slot="{ selectedClass }"
      >
        <slot
          name="sliderContent"
          :selectedClass="selectedClass"
          :item="item"
        ></slot>
      </v-slide-group-item>
    </v-slide-group>
    <div class="d-flex justify-center mb-6 pb-5">
      <v-btn color="success" @click="navigate(linkMore)">View More</v-btn>
    </div>
  </v-sheet>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
    items: {
      type: Array,
      required: true,
    },
    linkMore: {
      type: String,
      required: true,
    },
  },
  methods: {
    navigate(route) {
      this.$router.push({ name: route });
    },
  },
};
</script>
