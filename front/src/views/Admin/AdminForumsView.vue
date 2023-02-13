<template>
  <v-container>
    <div v-if="forums.length > 0">
      <TableAdmin
        :headers="headers"
        :objectValues="getForums"
        routeEdit="admin-forum-edit"
        actionDelete="deleteForum"
      ></TableAdmin>
    </div>
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
      { name: "Created By", value: "createdBy", valueKey: "username" },
      { name: "Validated", value: "isValid" },
    ],
    forums: [],
  }),
  mounted() {
    this.$store.dispatch("getAllForums").then(() => {
      this.forums = this.getForums;
    });
  },
  computed: {
    ...mapGetters(["getForums"]),
  },
  components: { TableAdmin },
};
</script>
