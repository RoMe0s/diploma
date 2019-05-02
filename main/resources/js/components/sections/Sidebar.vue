<template>
    <component :is="this.$root.authenticated.role" v-if="hasChild()"></component>
</template>

<script>
  import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
  import Customer from './sidebar/Customer';
  import Author from './sidebar/Author';
  import Admin from './sidebar/Admin';

  export default {
    components: {
      customer: Customer,
      author: Author,
      admin: Admin
    },
    methods: {
      hasChild() {
        return this.$root.authenticated !== null && this.$root.authenticated.role in this.$options.components;
      }
    }
  }
</script>