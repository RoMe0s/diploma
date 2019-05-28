<template>
    <sidebar-menu :menu="menu" theme="white-theme" @collapse="onCollapse"></sidebar-menu>
</template>

<script>
  import MenuMixin from './../../../mixins/sidebar/menu';

  export default {
    mixins: [MenuMixin],
    data() {
      return {
        ordersCount: 0
      }
    },
    computed: {
      menu() {
        return [
          {
            href: '/',
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
    },
    created() {
      this.sendRequest("customer.orders.count")
        .then(response => this.ordersCount = response.data.count)
    }
  }
</script>
