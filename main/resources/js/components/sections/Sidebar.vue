<template>
    <component :is="this.getUser().role" v-if="hasChild()"></component>
</template>

<script>
  import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
  import Customer from './sidebar/Customer'
  import Author from './sidebar/Author'

  export default {
    components: {
      customer: Customer,
      author: Author
    },
    methods: {
      hasChild() {
        return this.getUser() !== null && this.getUser().role in this.$options.components;
      }
    }
  }
</script>