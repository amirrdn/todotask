<template>
  <div class="container">
    <h1 class="text-danger">To Do List</h1>
    <list-view :items="arrayitem" v-on:reloadlist="getItems()" class="text-center" />
  </div>
</template>

<script>
import listView from "./components/listView.vue";
export default {
  components: {
    listView,
  },
  data: function () {
    return {
      items: [],
    };
  },
  computed: {
    arrayitem() {
      return this.items;
    },
  },
  methods: {
    getItems() {
      axios
        .get("api/task")
        .then((res) => {
          this.items = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getItems();
  },
};
</script>
