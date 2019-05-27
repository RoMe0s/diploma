import DeleteConfirmMixin from "../../../../mixins/deleteConfirm"
import FormComponent from "../form/form.vue"

export default {
  mixins: [DeleteConfirmMixin],
  components: {
    FormComponent
  },
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      value: null
    }
  },
  methods: {
    showDeleteConfirm() {
      this.deleteConfirm(() => {
        this.sendRequest("customer.orders.destroy", this.id)
          .then(() => Swal.fire({
            title: this.__("messages.deleted!"),
            type: "success"
          }).then(() => window.location.href = "/orders"))
      });
    },
    update() {
      this.validateAll().then(() => this.sendRequest("customer.orders.update", [this.id, this.value])
        .then(() => Swal.fire(this.__("messages.saved!"), "", "success")))
    },
    showPublishConfirm() {
      Swal.fire({
        title: this.__("messages.are you sure?"),
        showCancelButton: true,
        type: "success",
        confirmButtonText: this.__("messages.publish order"),
        cancelButtonText: this.__("messages.cancel")
      }).then(answer => {
        if (answer.value === true) {
          this.sendRequest("customer.orders.publish", this.id)
            .then(() => {
              this.$set(this.value, "can_be_rolled_back", true)
              this.$set(this.value, "can_be_published", false)
              Swal.fire({
                title: this.__("messages.published!"),
                type: "success"
              });
            })
            .catch(error => {
              Swal.fire({
                text: _.join(_.flattenDeep(_.values(error.response.data.errors)), "\n"),
                title: this.__("messages.error"),
                type: "error"
              });
            })
        }
      });
    },
    showRollbackConfirm() {
      Swal.fire({
        title: this.__("messages.are you sure?"),
        showCancelButton: true,
        type: "warning",
        confirmButtonText: this.__("messages.rollback order"),
        cancelButtonText: this.__("messages.cancel")
      }).then(answer => {
        if (answer.value === true) {
          this.sendRequest("customer.orders.rollback", this.id)
            .then(() => {
              this.$set(this.value, "can_be_rolled_back", false)
              this.$set(this.value, "can_be_published", true)
              Swal.fire({
                title: this.__("messages.rolled back!"),
                type: "success"
              });
            })
        }
      });
    }
  },
  created() {
    this.sendRequest("customer.orders.show", this.id)
      .then(response => this.value = response.data)
  }
}
