<template>
  <tr :class="[item.completed ? 'completed' : '', 'item']">
    <td>
      <span>{{ item.name }}</span>
    </td>
    <td>{{ item.user.name }}</td>
    <td>{{ item.user.email }}</td>
    <td>
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-outline-primary">
          <input
            class="form-check-input mt-0"
            type="checkbox"
            @change="updateCheck()"
            v-model="item.completed"
            id="inlineCheckbox1"
          />
        </button>
        <button type="button" class="btn btn-primary" v-on:click="removeItem()">
          <i class="pi pi-times"></i>
        </button>
        <button type="button" class="btn btn-info" v-on:click="showModal(item)">
          <i class="pi pi-eye"></i>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  props: ["item"],
  methods: {
    showModal(obj) {
      this.$emit("showModal", obj);
    },
    updateCheck() {
      axios
        .put(`api/task/${this.item._id}`, {
          item: this.item,
        })
        .then((res) => {
          if (res.status == 200) {
            this.$emit("itemchanged");
          }
        })
        .catch((error) => {
          console.log("error from axios put", errors);
        });
    },
    removeItem() {
      axios
        .delete(`api/task/${this.item._id}`)
        .then((res) => {
          if (res.status == 200) {
            this.$emit("itemchanged");
          }
        })
        .catch((error) => {
          console.log("error from axios delte ", error);
        });
    },
  },
};
</script>

<style>
.completed {
  text-decoration: line-through;
  color: gray;
}
.item {
  word-break: break-all;
}
</style>
