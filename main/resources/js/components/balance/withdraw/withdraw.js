export default {
  props: {
    route: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      amount: null,
      exp_month: null,
      exp_year: null,
      cvv: null
    };
  },
  methods: {
    showConfirm() {
      this.validateAll().then(isValid => {
        if (isValid) {
          Swal.fire({
            type: "info",
            title: this.__("messages.are you sure?"),
            showCancelButton: true,
            confirmButtonText: this.__("messages.yes, withdraw funds!"),
            cancelButtonText: this.__("messages.cancel")
          }).then(answer => {
            if (answer.value === true) {
              this.sendRequest(this.route, {amount: this.amount})
                .then(() => {
                  Swal.fire(this.__("messages.has been withdrawn successfully!"), "", "success")
                    .then(() => window.location.reload());
                });
            }
          });
        }
      })
    }
  }
}
