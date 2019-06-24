import PlanComponent from "./plan/plan.vue";
import SettingsComponent from "./settings/settings.vue";
import ChecksComponent from "./checks/checks.vue";

export default {
  components: {
    PlanComponent,
    SettingsComponent,
    ChecksComponent
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
    };
  },
  methods: {
    showAcceptConfirm() {
      Swal.fire({
        type: "info",
        title: this.__("messages.are you sure?"),
        showCancelButton: true,
        confirmButtonText: this.__("messages.yes, accept!"),
        cancelButtonText: this.__("messages.cancel")
      }).then(answer => {
        if (answer.value === true) {
          this.sendRequest("customer.tasks.accept", this.id)
            .then(() => Swal.fire(this.__("messages.has been sent!"), "", "success")
              .then(() => window.location.href = "/checks"));
        }
      });
    },
    showRollbackConfirm() {
      Swal.fire({
        type: "info",
        showCancelButton: true,
        title: this.__("messages.are you sure?"),
        confirmButtonText: this.__("messages.yes, rollback!"),
        cancelButtonText: this.__("messages.cancel"),
        input: "textarea",
        inputPlaceholder: this.__("messages.rollback reason"),
        inputValidator: (value) => {
          if (!value) {
            return this.__("messages.the reason is required");
          }
          if (value.length > 1000) {
            return this.__("messages.should be equal or less than 1000 characters");
          }
        }
      }).then(answer => {
        if (_.isString(answer.value)) {
          this.sendRequest("customer.tasks.rollback", [this.id, answer.value])
            .then(() => Swal.fire(this.__("messages.has been rolled back!"), "", "success")
              .then(() => window.location.href = "/checks"));
        }
      });
    }
  },
  created() {
    this.sendRequest("customer.tasks.show", this.id)
      .then(response => this.value = response.data);
  }
}
