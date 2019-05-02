import {SidebarMenu} from 'vue-sidebar-menu';

const separator = {
  template: '<hr style="border-color: rgba(0,0,0,0.1); margin: 20px;">'
};

export default {
  components: {SidebarMenu},
  methods: {
    getSeparator() {
      return separator;
    },
    onCollapse(collapsed) {
      this.$root.collapsed = collapsed;
    }
  }
};