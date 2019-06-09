import WithdrawForm from "../../balance/withdraw/withdraw.vue";

export default {
  components: {
    WithdrawForm
  },
  data() {
    return {
      showWithdrawForm: false,
      amount: null,
      billIsEmpty: true,
      available: null,
      locked: null,
      bill: null
    }
  },
  created() {
    this.sendRequest("author.balance.index")
      .then(response => {
        this.amount = response.data.amount
        this.available = response.data.available
        this.locked = response.data.locked
        this.bill = response.data.bill
        this.billIsEmpty = _.isNil(this.bill)
      })
  },
  methods: {
    update() {
      this.validate("bill").then(isValid => {
        if (isValid) {
          this.sendRequest("author.balance.update", {bill: this.bill})
            .then(() => {
              this.billIsEmpty = false;
              Swal.fire(this.__("messages.saved!"), "", "success");
            })
        }
      })
    },
    toggleWithdrawForm() {
      this.showWithdrawForm = !this.showWithdrawForm;
    }
  }
}