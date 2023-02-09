<template>
  <v-btn color="primary" @click="linkEdit(routeEdit, 'new')"> Add </v-btn>
  <v-table>
    <thead>
      <tr>
        <th v-for="header in headers" :key="header.value" class="text-left">
          {{ header.name }}
        </th>
        <th class="text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="object in objectValues" :key="object.id">
        <td v-for="item in headers" :key="item.value">
          {{ object[item.value] }}
        </td>
        <td>
          <v-btn color="primary" @click="linkEdit(routeEdit, object.id)">
            Edit
          </v-btn>
          <v-btn color="error" @click="deleteItem(actionDelete, object)">
            Delete
          </v-btn>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>

<script>
export default {
  props: {
    headers: {
      type: Array,
      required: true,
    },
    objectValues: {
      type: Object,
      required: true,
    },
    routeEdit: {
      type: String,
      required: true,
    },
    actionDelete: {
      type: String,
      required: true,
    },
  },
  methods: {
    linkEdit(route, id) {
      this.$router.push({ name: route, params: { id: id } });
    },
    deleteItem(actions, item) {
      this.$store.dispatch(actions, item);
    },
  },
};
</script>
