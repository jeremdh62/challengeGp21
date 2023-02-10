<template>
  <v-container>
    <TableAdmin
      :headers="headers"
      :objectValues="getForums"
      routeEdit="admin-forum-edit"
      actionDelete="deleteForum"
    ></TableAdmin>
  </v-container>
</template>
<script>
import { mapGetters } from "vuex";
import TableAdmin from "../../components/TableAdmin.vue";

export default {
  data: () => ({
    headers: [
      { name: "Title", value: "title" },
      { name: "Created At", value: "createdAt" },
      { name: "Created By", value: "createdBy" },
      { name: "Validated", value: "isValid" },
    ],
  }),
  mounted() {
    this.$store.dispatch("getAllForums");
  },
  computed: {
    ...mapGetters(["getForums"]),
  },
  components: { TableAdmin },
};
</script>
