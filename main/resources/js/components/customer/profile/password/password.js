export default {
  data() {
    return {
      password: null,
      password_confirmation: null
    }
  },
  methods: {
    change() {
      this.validateAll().then(isValid => {
        if (isValid) {
          this.sendRequest("customer.profile.password", {
            password: this.password,
            password_confirmation: this.password_confirmation
          }).then(() => Swal.fire(this.__("messages.changed!"), "", "success"))
        }
      })
    }
  }
}
