import PlanComponent from "./plan/plan.vue";

export default {
  components: {
    PlanComponent
  },
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      value: null
    };
  },
  methods: {
    showCancelConfirm() {
      Swal.fire({
        type: "error",
        title: this.__("messages.are you sure?"),
        showCancelButton: true,
        confirmButtonText: this.__("messages.yes, stop working!"),
        cancelButtonText: this.__("messages.cancel")
      }).then(answer => {
        if (answer.value === true) {
          this.sendRequest("author.tasks.cancel", this.id)
            .then(() => {
              Swal.fire({
                title: this.__("messages.have been canceled!"),
                type: "success"
              }).then(() => window.location.href = "/tasks");
            });
        }
      });
    }
  },
  created() {
    this.sendRequest("author.tasks.show", this.id)
      .then(response => this.value = response.data);
  },
  mounted() {
    Echo.private("Author.Task." + this.id)
      .listen("Author\\Task\\TimeIsOver", () => {
        Swal.fire(this.__("messages.unfortunately, the time is over"), "", "error")
          .then(() => window.location.href = "/tasks");
        this.eventHub.$emit("task-was-failed");
      });
  }
}