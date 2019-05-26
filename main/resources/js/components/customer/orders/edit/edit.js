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
        .then(response => Swal.fire(this.__("messages.saved!"), "", "success")))
    }
  },
  created() {
    this.sendRequest("customer.orders.show", this.id)
      .then(response => this.value = response.data)
  }
}
