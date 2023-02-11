<template>
  <div
    class="d-flex justify-space-between align-center flex-column flex-sm-row fill-height"
  >
    <v-btn color="teal accent-4" @click="navigator('admin')"> Back </v-btn>
    <v-btn color="primary" @click="linkEdit(routeEdit, 'new')"> Add </v-btn>
  </div>
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
          <span v-if="typeof object[item.value] === 'boolean'">
            <v-icon color="success" v-if="object[item.value] === true">
              mdi-check
            </v-icon>
            <v-icon color="error" v-else> mdi-close </v-icon>
          </span>

          <span v-else>
            <span v-if="item.valueKey === undefined">
              {{ object[item.value] }}
            </span>

            <span v-else> {{ object[item.value][item.valueKey] }} </span>
          </span>
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
    navigator(route) {
      this.$router.push({ name: route });
    },
    linkEdit(route, id) {
      this.$router.push({ name: route, params: { id: id } });
    },
    deleteItem(actions, item) {
      this.$store.dispatch(actions, item);
    },
  },
};
</script>
