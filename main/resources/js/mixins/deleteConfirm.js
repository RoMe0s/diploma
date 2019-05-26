export default {
  methods: {
    deleteConfirm(callback) {
      Swal.fire({
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6cb2eb",
        cancelButtonColor: "#e3342f",
        title: this.__("messages.are you sure?"),
        text: this.__("messages.you won't be able to revert this!"),
        confirmButtonText: this.__("messages.yes, delete it!"),
        cancelButtonText: this.__("messages.cancel")
      }).then(result => result.value && callback());
    }
  }
}
