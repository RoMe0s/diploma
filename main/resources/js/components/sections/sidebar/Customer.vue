<template>
    <sidebar-menu :menu="menu" theme="white-theme" @collapse="onCollapse"></sidebar-menu>
</template>

<script>
  import MenuMixin from './../../../mixins/sidebar/menu';

  export default {
    mixins: [MenuMixin],
    data() {
      return {
        ordersCount: 0,
        tasksCount: 0
      }
    },
    computed: {
      menu() {
        return [
          {
            href: '/',
            title: this.__('messages.balance'),
            icon: 'fa fa-coins'
          },
          {
            header: true,
            component: this.getSeparator(),
            visibleOnCollapse: true
          },
          {
            href: '/orders',
            title: this.__('messages.orders'),
            icon: 'fa fa-tasks',
            badge: {
              text: this.ordersCount,
              class: 'default-badge'
            }
          },
          {
            href: '/checks',
            title: this.__('messages.on check'),
            icon: 'fa fa-clock',
            badge: {
              text: this.tasksCount,
              class: 'default-badge'
            }
          },
          {
            href: '/projects',
            title: this.__('messages.projects'),
            icon: 'fa fa-boxes'
          },
          {
            href: '/settings',
            title: this.__('messages.settings'),
            icon: 'fa fa-cog'
          }
        ];
      }
    },
    created() {
      this.sendRequest("customer.orders.count")
        .then(response => this.ordersCount = response.data.count)

      this.sendRequest("customer.tasks.count")
        .then(response => this.tasksCount = response.data.count)
    }
  }
</script>
