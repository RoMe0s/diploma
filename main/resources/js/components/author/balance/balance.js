export default {
  data() {
    return {
      amount: null,
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
      })
  },
  methods: {
    update() {
      this.validate("bill").then(isValid => {
        if (isValid) {
          this.sendRequest("author.balance.update", {bill: this.bill})
            .then(() => Swal.fire(this.__("messages.saved!"), "", "success"))
        }
      })
    }
  }
}