import RefillForm from "../../balance/refill/refill.vue";
import WithdrawForm from "../../balance/withdraw/withdraw.vue";

export default {
  components: {
    RefillForm,
    WithdrawForm
  },
  data() {
    return {
      showWithdrawForm: false,
      showRefillForm: false,
      billIsEmpty: true,
      available: null,
      amount: null,
      locked: null,
      bill: null
    }
  },
  methods: {
    update() {
      this.validate("bill").then(isValid => {
        if (isValid) {
          this.sendRequest("customer.balance.update", {bill: this.bill})
            .then(() => {
              this.billIsEmpty = false;
              Swal.fire(this.__("messages.saved!"), "", "success");
            });
        }
      });
    },
    toggleRefillForm() {
      this.showRefillForm = !this.showRefillForm;
      if (this.showRefillForm) {
        this.showWithdrawForm = false;
      }
    },
    toggleWithdrawForm() {
      this.showWithdrawForm = !this.showWithdrawForm;
      if (this.showWithdrawForm) {
        this.showRefillForm = false;
      }
    }
  },
  created() {
    this.sendRequest("customer.balance.index")
      .then(response => {
        this.amount = response.data.amount
        this.available = response.data.available
        this.locked = response.data.locked
        this.bill = response.data.bill
        this.billIsEmpty = _.isNil(this.bill)
      })
  }
}
