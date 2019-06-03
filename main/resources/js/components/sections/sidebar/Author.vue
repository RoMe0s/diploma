<template>
    <sidebar-menu :menu="menu" theme="white-theme" @collapse="onCollapse"></sidebar-menu>
</template>

<script>
  import MenuMixin from "./../../../mixins/sidebar/menu"

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
            href: "/",
            title: this.__("pages.balance"),
            icon: "fa fa-coins"
          },
          {
            header: true,
            component: this.getSeparator(),
            visibleOnCollapse: true
          },
          {
            href: "/orders",
            title: this.__("pages.orders"),
            icon: "fa fa-folder",
            badge: {
              text: this.ordersCount,
              class: "badge-danger"
            }
          },
          {
            href: "/tasks",
            title: this.__("pages.tasks"),
            icon: "fa fa-tasks"
          }
        ]
      }
    },
    methods: {
      decrementOrdersCount() {
        this.ordersCount--;
      }
    },
    created() {
      this.eventHub.$on("order-was-taken", this.decrementOrdersCount)
      this.sendRequest("author.orders.count")
        .then(response => this.ordersCount = response.data.count)
    }
  }
</script>