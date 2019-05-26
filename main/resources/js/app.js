/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Toasted from 'vue-toasted';
import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue';

import RequestMixin from './mixins/request';
import TranslateMixin from './mixins/translation';
import ValidationMixin from './mixins/validation';

import AuthRegister from './components/auth/Register';
import AuthLogin from './components/auth/Login';
import TopMenu from './components/sections/TopMenu';
import Sidebar from './components/sections/Sidebar';

import CustomerProjectsCreate from './components/customer/projects/Create';
import CustomerProjectsIndex from './components/customer/projects/Index';
import CustomerProjectsEdit from './components/customer/projects/Edit';
import CustomerProjectsSettingsIndex from './components/customer/projects/settings/Index';

import CustomerSettingsIndex from './components/customer/settings/Index';

import CustomerOrdersIndex from './components/customer/orders/Index';
import CustomerOrdersCreate from './components/customer/orders/Create';
import CustomerOrdersEdit from './components/customer/orders/edit/edit.vue';

Vue.use(VeeValidate, {
  inject: true,
  fieldsBagName: 'veeFields'
});
Vue.use(BootstrapVue);
Vue.use(Toasted, {
  duration: 10000
});

Vue.mixin({
  mixins: [TranslateMixin, ValidationMixin, RequestMixin],
  methods: {
    notify(message, type = 'error') {
      this.$toasted[type](message);
    }
  }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  components: {
    AuthRegister,
    AuthLogin,
    Sidebar,
    TopMenu,

    CustomerProjectsSettingsIndex,
    CustomerProjectsCreate,
    CustomerProjectsIndex,
    CustomerProjectsEdit,
    CustomerSettingsIndex,

    CustomerOrdersIndex,
    CustomerOrdersCreate,
    CustomerOrdersEdit
  },
  created() {
    this.sendRequest('auth.user')
      .then(response => this.authenticated = response.data.user);
  },
  data() {
    return {
      collapsed: null,
      authenticated: null
    }
  }
});
