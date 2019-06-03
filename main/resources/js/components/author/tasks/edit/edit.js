//TODO: add edit endpoint

export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      value: {
        name: null,
        expired_at: "22 hours from now",
        order: {
          price: {
            min: 100,
            max: 200
          },
          sizes: {
            from: 1000,
            to: 1750
          },
          name: "test name",
          description: "Lorem ipsum"
        }
      }
    };
  },
  methods: {},
  created() {
    this.sendRequest("author.tasks.show", this.id)
      .then(response => {
        this.value = response.data;
      });
  },
  mounted() {
    Echo.private("Author.Task." + this.id)
      .listen("Author\\Task\\TimeIsOver", () => {
        Swal.fire(this.__("messages.unfortunately, the time is over"), "", "error")
          .then(() => window.location.href = "/tasks");
      });
  }
}