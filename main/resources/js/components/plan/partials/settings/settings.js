export default {
  props: {
    blocks: {
      type: Object,
      required: true
    },
    value: {
      type: Object,
      required: true
    }
  },
  methods: {
    deleteRecord() {
      this.$emit("delete");
    }
  }
}