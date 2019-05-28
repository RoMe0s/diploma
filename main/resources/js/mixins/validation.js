export default {
  methods: {
    validateAllRecursive(promises = []) {
      promises.push(this.$validator.validateAll());
      this.$children.forEach($child => $child.validateAllRecursive(promises));
      return promises;
    },
    async validateAll() {
      return await Promise.all(this.validateAllRecursive())
        .then(validations => validations.indexOf(false) < 0)
    },
    async validate(field) {
      return await this.$validator.validate(field)
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
      this.$validator.reset().then(console.log);
    },
    addErrorToChildren(field, error) {
      if (field in this.veeFields) {
        this.errors.add({field, msg: error});
      } else {
        this.$children.forEach($child => $child.addErrorToChildren(field, error));
      }
    },
    resetValidationRecursive() {
      this.resetValidation();
      this.$children.forEach($child => $child.resetValidationRecursive());
    }
  }
}
