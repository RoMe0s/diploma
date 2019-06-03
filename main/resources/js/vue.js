import Vue from "vue"
import Toasted from "vue-toasted"
import VeeValidate from "vee-validate"
import BootstrapVue from "bootstrap-vue"

import RequestMixin from "./mixins/request"
import TranslateMixin from "./mixins/translation"
import ValidationMixin from "./mixins/validation"

Vue.use(VeeValidate, {
  inject: true,
  fieldsBagName: "veeFields"
})
Vue.use(BootstrapVue)
Vue.use(Toasted, {
  duration: 10000
})

Vue.prototype.eventHub = new Vue()

Vue.mixin({
  mixins: [TranslateMixin, ValidationMixin, RequestMixin],
  methods: {
    notify(message, type = "error") {
      this.$toasted[type](message)
    },
    getUser() {
      return this.$root.authenticated
    }
  }
})

export default Vue