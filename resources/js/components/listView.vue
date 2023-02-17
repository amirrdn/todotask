<template>
  <FormTask v-on:itemchanged="$emit('reloadlist')" />
  <div class="mt-4">
    <h4>list view</h4>
    <hr class="w-50 m-auto mb-3" />
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Assigned</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <list-item
          :item="item"
          v-on:itemchanged="$emit('reloadlist')"
          v-on:showModal="showModal"
          v-for="item in items"
          :key="item.id"
        />
      </tbody>
    </table>
  </div>
  <div ref="myModalId" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title text-white">
            {{ newItem == null ? "" : newItem.name }}
          </h5>
          <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-primary" v-if="newItem">
            <tr>
              <td>Name</td>
              <td>:</td>
              <td>
                <template v-if="action == 'view'">
                  {{ newItem.name }}
                </template>
                <template v-else>
                  <input type="text" class="form-control" v-model="newItem.name" />
                </template>
              </td>
            </tr>
            <tr>
              <td>Assigned</td>
              <td>:</td>
              <td>{{ newItem.user.name }}</td>
            </tr>
            <tr>
              <td>Email</td>
              <td>:</td>
              <td>{{ newItem.user.email }}</td>
            </tr>
            <tr>
              <td>Status</td>
              <td>:</td>
              <td>
                <template v-if="action == 'view'">
                  <span class="badge text-bg-success" v-if="newItem.completed"
                    >Complated</span
                  >
                  <span class="badge text-bg-warning" v-else>Pending</span>
                </template>
                <template v-else>
                  <div class="mb-3">
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="inlineRadioOptions"
                        id="inlineRadio1"
                        value="true"
                        v-model="newItem.completed"
                        :checked="newItem.completed"
                      />
                      <label class="form-check-label" for="inlineRadio1">Complate</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input
                        class="form-check-input"
                        type="radio"
                        name="inlineRadioOptions"
                        id="inlineRadio2"
                        value="false"
                        v-model="newItem.completed"
                        :checked="!newItem.completed"
                      />
                      <label class="form-check-label" for="inlineRadio2">Pending</label>
                    </div>
                  </div>
                </template>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-warning"
            v-if="action == 'edit'"
            v-on:click="Saveaction"
          >
            Update
          </button>
          <button
            type="button"
            class="btn btn-primary"
            v-on:click="action = 'edit'"
            v-if="action == 'view'"
          >
            Edit
          </button>
          <button
            type="button"
            class="btn btn-danger"
            v-on:click="action = 'view'"
            v-if="action == 'edit'"
          >
            Cancel
          </button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FormTask from "./Addtask.vue";
import listItem from "./Listtask.vue";
import { Modal } from "bootstrap";
export default {
  components: {
    FormTask,
    listItem,
  },
  props: ["items"],
  data() {
    return {
      myModal: null,
      myModalText: null,
      newItem: null,
      action: "view",
      loading: false,
    };
  },
  mounted() {
    this.myModal = new Modal(this.$refs.myModalId);
  },
  methods: {
    showModal(obj) {
      this.newItem = obj;
      this.myModal.show();
    },
    Saveaction() {
      axios
        .put(`api/task/${this.newItem._id}`, {
          item: this.newItem,
        })
        .then((res) => {
          this.$emit("itemchanged");
          this.loading = false;
          this.$toast.add({
            severity: "success",
            summary: "Success Message",
            detail: "Task insert",
            life: 3000,
          });
          this.myModal.hide();
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
          this.$toast.add({
            severity: "error",
            summary: "Rejected",
            detail: "Erorr insert",
            life: 3000,
          });
        });
    },
  },
};
</script>

<style scoped></style>
