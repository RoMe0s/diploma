export default {
  props: {
    blocks: {
      type: Object,
      required: true
    },
    value: {
      type: Object,
      required: true
    },
    validationNamePrefix: {
      type: String,
      required: true
    }
  },
  methods: {
    deleteRecord() {
      this.$emit("delete");
    },
    validationName(ref) {
      return `${this.validationNamePrefix}.${ref}`;
    }
  }
}
