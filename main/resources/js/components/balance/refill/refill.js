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
            confirmButtonText: this.__("messages.yes, refill!"),
            cancelButtonText: this.__("messages.cancel")
          }).then(answer => {
            if (answer.value === true) {
              this.sendRequest(this.route, {
                amount: this.amount,
                exp_month: this.exp_month,
                exp_year: this.exp_year,
                cvv: this.cvv
              }).then(() => {
                Swal.fire(this.__("messages.has been refilled successfully!"), "", "success")
                  .then(() => window.location.reload());
              });
            }
          });
        }
      });
    }
  }
}
