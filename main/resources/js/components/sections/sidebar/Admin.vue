<template>
    <sidebar-menu :menu="menu" theme="white-theme"></sidebar-menu>
</template>

<script>
  import MenuMixin from './../../../mixins/sidebar/menu';

  export default {
    mixins: [MenuMixin],
    data() {
      return {
        menu: []
      }
    }
  }
</script>