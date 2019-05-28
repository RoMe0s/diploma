export default {
  methods: {
    logout() {
      this.sendRequest("auth.logout")
        .then(() => {
          window.location.href = '/login'
        })
    }
  }
}