import DeleteConfirmMixin from "../../../../mixins/deleteConfirm.js"
import {blockSchema} from "../../../../helpers/plan"
import PlanComponent from "./plan/plan.vue"

export default {
  mixins: [DeleteConfirmMixin],
  components: {
    PlanComponent
  },
  props: {
    value: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      projects: []
    }
  },
  computed: {
    hasBlocks() {
      return !!this.value.plan.blocks.length
    }
  },
  methods: {
    initPlan() {
      this.value.plan.blocks.push(blockSchema())
    },
    clearPlan() {
      this.deleteConfirm(() => this.value.plan.blocks.splice(0, this.value.plan.blocks.length))
    },
    clearProjectId() {
      this.$set(this.value, "project_id", null)
    }
  },
  created() {
    this.sendRequest("customer.projects.compact")
      .then(response => this.projects = response.data)
  }
}
