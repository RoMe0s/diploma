<template>
    <sidebar-menu :menu="menu" theme="white-theme" @collapse="onCollapse"></sidebar-menu>
</template>

<script>
  import MenuMixin from "./../../../mixins/sidebar/menu"

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
              class: "default-badge"
            }
          },
          {
            href: "/tasks",
            title: this.__("pages.tasks"),
            icon: "fa fa-tasks",
            badge: {
              text: this.tasksCount,
              class: "default-badge"
            }
          },
          {
            href: "/tasks/done",
            title: this.__("pages.done tasks"),
            icon: "fa fa-clipboard-check"
          }
        ]
      }
    },
    methods: {
      changeCountersForNewOrder() {
        this.ordersCount--;
        this.tasksCount++;
      },
      decrementTasksCount() {
        this.tasksCount--;
      }
    },
    created() {
      this.eventHub.$on("order-was-taken", this.changeCountersForNewOrder);
      this.eventHub.$on("task-was-failed", this.decrementTasksCount);

      this.sendRequest("author.orders.count")
        .then(response => this.ordersCount = response.data.count);

      this.sendRequest("author.tasks.count")
        .then(response => this.tasksCount = response.data.count);
    }
  }
</script>
