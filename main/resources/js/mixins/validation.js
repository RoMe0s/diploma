export default {
  methods: {
    validateAll() {
      return this.$validator.validateAll()
        .then(isValid => new Promise((resolve, reject) => isValid ? resolve() : reject('Invalid!')));
    },
    validate(field) {
      return this.$validator.validate(field)
        .then(isValid => new Promise((resolve, reject) => isValid ? resolve() : reject('Invalid!')));
    },
    noErrors(ref) {
      if (this.errors.has(ref)) {
        return false;
      }
      if (this.veeFields[ref] && (this.veeFields[ref].dirty || this.veeFields[ref].validated)) {
        return true;
      }
      return null;
    }
  }
}