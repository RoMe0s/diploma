<template>
    <sidebar-menu :menu="menu" theme="white-theme" @collapse="onCollapse"></sidebar-menu>
</template>

<script>
  import MenuMixin from './../../../mixins/sidebar/menu';

  export default {
    mixins: [MenuMixin],
    data() {
      return {
        ordersCount: 150
      }
    },
    computed: {
      menu() {
        return [
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
              text: this.ordersCount,
              class: 'badge-danger'
            }
          },
          {
            href: '/projects',
            title: this.__('pages.projects'),
            icon: 'fa fa-boxes'
          },
          {
            href: '/settings',
            title: this.__('pages.settings'),
            icon: 'fa fa-cog'
          }
        ];
      }
    }
  }
</script>