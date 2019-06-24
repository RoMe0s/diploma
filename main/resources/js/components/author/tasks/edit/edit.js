import PlanComponent from "./plan/plan.vue";
import SettingsComponent from "./settings/settings.vue";
import ChecksComponent from "./checks/checks.vue";

export default {
  components: {
    PlanComponent,
    SettingsComponent,
    ChecksComponent
  },
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      contentError: null,
      wasChanged: false,
      isEdited: false,
      onCheck: false,
      value: null,
      checks: []
    };
  },
  computed: {
    isEditable() {
      return !this.onCheck && this.value && this.value.is_editable === true;
    }
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
    },
    save() {
      this.sendRequest("author.tasks.update", [this.id, this.value.text])
        .catch(error => this.contentError = _.get(error, "response.data.errors.content[0]", null))
        .then(() => this.isEdited = false);
    },
    sendToCheck() {
      Swal.fire({
        type: "info",
        title: this.__("messages.are you sure?"),
        showCancelButton: true,
        confirmButtonText: this.__("messages.yes, send to check!"),
        cancelButtonText: this.__("messages.cancel")
      }).then(answer => {
        if (answer.value === true) {
          this.sendRequest("author.tasks.to-check", this.id)
            .then(() => {
              this.onCheck = true;
              Swal.fire(this.__("messages.have been sent!"), "", "success");
            });
        }
      });
    },
    debouncedSave: _.debounce(function () {
      this.contentError === null && this.isEdited && this.save();
    }, 15000),
    textChanged(content) {
      this.isEdited = true;
      this.wasChanged = true;
      this.contentError = null;
      this.$set(this.value.text, "content", content);
      this.debouncedSave();
    },
    refresh() {
      this.sendRequest("author.tasks.show", this.id)
        .then(response => {
          this.value = response.data;
          this.onCheck = false;
        });
    }
  },
  created() {
    this.refresh();
  },
  mounted() {
    Echo.private("Author.Task." + this.id)
      .listen("Author\\Task\\Checked", () => {
        Swal.fire(this.__("messages.checked!"), "", "info");
        this.refresh();
      })
      .listen("Author\\Task\\TimeIsOver", () => {
        Swal.fire(this.__("messages.unfortunately, the time is over"), "", "error")
          .then(() => window.location.href = "/tasks");
        this.eventHub.$emit("task-was-failed");
      });
  }
}
