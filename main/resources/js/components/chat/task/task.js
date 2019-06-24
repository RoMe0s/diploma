export default {
  props: {
    sendRoute: {
      type: String,
      required: true
    },
    loadRoute: {
      type: String,
      required: true
    },
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      message: null,
      messages: [],
      sender: null
    };
  },
  methods: {
    scrollToBottom() {
      this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
    },
    send() {
      this.validateAll().then(isValid => {
        if (isValid) {
          this.sendRequest(this.sendRoute, [this.id, this.message])
            .then(response => {
              this.notify(this.__("messages.has been sent!"), "success");
              this.messages.push(response.data);
              this.$nextTick(this.scrollToBottom);
              this.resetValidation();
              this.message = null;
            });
        }
      });
    }
  },
  created() {
    this.sendRequest(this.loadRoute, this.id)
      .then(response => {
        this.messages = response.data.messages;
        this.$nextTick(this.scrollToBottom);
        this.sender = response.data.sender;
      });
  }
}
