export default {
  data() {
    return {
      email: null,
      name: null
    }
  },
  created() {
    this.$root.$on("user-loaded", () => {
      this.email = this.getUser().email
      this.name = this.getUser().name
    })
  },
  methods: {
    save() {
      this.validateAll().then(isValid => {
        if (isValid) {
          this.sendRequest("customer.profile.update", {email: this.email, name: this.name})
            .then(() => Swal.fire(this.__("messages.saved!"), "", "success"))
        }
      })
    }
  }
}
