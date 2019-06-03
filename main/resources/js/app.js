const app = new Vue({
  el: '#app',
  created() {
    this.sendRequest("auth.user")
      .then(response => {
        this.authenticated = response.data.user
        this.$emit("user-loaded")
      });
  },
  data() {
    return {
      collapsed: null,
      authenticated: null
    }
  }
});
