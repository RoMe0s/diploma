let forceValidation = false;

export default {
  methods: {
    validateAll() {
      forceValidation = true;
      return this.$validator.validateAll()
          .then(isValid => isValid && new Promise(resolve => resolve()));
    }
  },
  computed: {
    noErrors() {
      return field => {
        if (!forceValidation && this.$data[field] === null) {
          return null;
        }
        return !this.errors.has(field);
      };
    }
  }
}