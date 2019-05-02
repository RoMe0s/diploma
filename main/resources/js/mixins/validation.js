let forceValidation = false;

export default {
  methods: {
    validateAll() {
      forceValidation = true;
      return this.$validator.validateAll()
        .then(isValid => new Promise((resolve, reject) => isValid ? resolve() : reject('Invalid!')));
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