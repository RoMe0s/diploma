<template>
    <sidebar-menu :menu="menu" theme="white-theme" @collapse="onCollapse"></sidebar-menu>
</template>

<script>
  import MenuMixin from './../../../mixins/sidebar/menu';

  export default {
    mixins: [MenuMixin],
    data() {
      return {
        menu: [
          {
            href: '/',
            title: this.__('pages.dashboard'),
            icon: 'fa fa-home'
          },
          {
            href: '/coins',
            title: this.__('pages.balance'),
            icon: 'fa fa-coins'
          },
          {
            header: true,
            component: this.getSeparator(),
            visibleOnCollapse: true
          },
          {
            href: '/orders',
            title: this.__('pages.orders'),
            icon: 'fa fa-tasks',
            badge: {
              text: 'new',
              class: 'badge-danger'
            }
          },
          {
            header: true,
            title: 'hehey'
          },
          {
            href: '/projects',
            title: this.__('pages.projects'),
            icon: 'fa fa-boxes'
          }
        ]
      }
    }
  }
</script>