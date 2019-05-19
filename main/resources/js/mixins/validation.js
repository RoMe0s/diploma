export default {
  methods: {
    validateAll() {
      let promises = [this.$validator.validateAll()];
      this.$children.forEach($child => promises.push($child.validateAll()));
      return Promise.all(promises).then(validations => {
        const isValid = validations.indexOf(false) < 0;
        return new Promise((resolve, reject) => isValid ? resolve() : reject('Invalid!'));
      });
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
    },
    resetValidation() {
      this.$validator.reset();
    }
  }
}