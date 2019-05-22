export default {
  methods: {
    validateAllRecursive(promises = []) {
      promises.push(this.$validator.validateAll());
      this.$children.forEach($child => $child.validateAllRecursive(promises));
      return promises;
    },
    validateAll() {
      return Promise.all(this.validateAllRecursive())
        .then(validations => {
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
    },
    addErrorToChildren(field, error) {
      this.errors.add({field, msg: error});
      this.$children.forEach($child => $child.addErrorToChildren(field, error));
    },
    resetValidationRecursive() {
      this.resetValidation();
      this.$children.forEach($child => $child.resetValidationRecursive());
    }
  }
}
