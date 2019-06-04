import BlockComponent from "./partials/block/block.vue";

export default {
  components: {
    BlockComponent
  },
  props: {
    value: {
      type: Object,
      required: true
    }
  }
}