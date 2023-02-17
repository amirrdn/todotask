<template>
  <div class="row">
    <div class="col-sm-12">
      <form v-on:submit="addItem">
        <fieldset>
          <legend>Add Task</legend>
          <div class="mb-3">
            <label for="disabledTextInput" class="form-label">Name</label>
            <input
              type="text"
              id="disabledTextInput"
              class="form-control"
              placeholder="Name"
              ref="name"
              v-model="item.name"
              required
            />
          </div>
          <div class="mb-3">
            <label for="disabledSelect" class="form-label">Assigned To</label>
            <Dropdown
              class="col-sm-12"
              v-model="selectedvalue"
              :options="optionsusers"
              optionLabel="text"
              placeholder="Select a Assigned To"
              v-on:change="GetAssigned($event)"
            />
          </div>
          <button type="submit" class="btn btn-sm btn-primary">
            <div class="spinner-border text-light" role="status" v-if="loading">
              <span class="visually-hidden">Loading...</span>
            </div>
            <span v-if="loading">Loading..</span>
            <span v-else>Submit</span>
          </button>
        </fieldset>
      </form>
    </div>
    <Toast />
  </div>
  <div ref="myModalId" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title text-white">Alert</h5>
          <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Data required</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal } from "bootstrap";
import Toast from "primevue/toast";
import Dropdown from "primevue/dropdown";

export default {
  components: {
    Toast,
    Dropdown,
  },
  data: function () {
    return {
      item: {
        name: null,
        assigned_to: null,
      },
      optionsusers: [],
      loading: false,
      myModal: null,
      myModalText: null,
      selectedvalue: null,
    };
  },
  mounted() {
    this.getUsers();
    this.myModal = new Modal(this.$refs.myModalId);
  },
  methods: {
    GetAssigned(event) {
      this.item.assigned_to = event.value.value;
    },
    ModalShow() {
      this.$refs.email.$el.focus();
      //this.myModal.show();
    },
    ModalHide() {
      this.myModal.hide();
    },
    getUsers() {
      axios.get("api/users").then((response) => {
        const datauser = response.data;
        let optuser = [];
        if (datauser.length > 0) {
          datauser.forEach((b) => {
            optuser.push({
              value: b._id,
              text: b.name,
            });
          });
        }
        this.optionsusers = optuser;
      });
    },
    addItem(e) {
      e.preventDefault();
      if (this.item.name == null) {
        this.$toast.add({
          severity: "error",
          summary: "Rejected",
          detail: "Please Insert field !",
          life: 3000,
        });
        this.ModalShow();
        return false;
      }
      if (this.item.assigned_to == null) {
        this.$toast.add({
          severity: "error",
          summary: "Rejected",
          detail: "Please select field !",
          life: 3000,
        });
        this.ModalShow();
        return false;
      }
      this.loading = true;
      axios
        .post("api/task/store", {
          item: this.item,
        })
        .then((res) => {
          this.item.name = null;
          this.selectedvalue = null;
          this.$emit("itemchanged");
          this.loading = false;
          this.$toast.add({
            severity: "success",
            summary: "Success Message",
            detail: "Task insert",
            life: 3000,
          });
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

<style scoped>
.active {
  color: white;
  background-color: blue;
}
.inactive {
  color: gray;
}
</style>
