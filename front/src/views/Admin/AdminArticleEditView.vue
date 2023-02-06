<template>
  <v-container>
    <v-form ref="form">
      <v-text-field label="Title" required></v-text-field>
      <QuillEditor theme="snow" />
      <div class="d-flex flex-column">
        <v-btn color="success" class="mt-4" block> Validate </v-btn>
        <v-btn color="error" class="mt-4" block> Cancel </v-btn>
      </div>
    </v-form>
  </v-container>
</template>
<script>
export default {
  name: "AdminArticleEditView",
  data() {
    return {
      title: "",
      content: "",
    };
  },
};
</script>
