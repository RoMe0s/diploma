import settingsComponent from "../settings/settings.vue";
import keysComponent from "../keys/keys.vue";

export default {
  components: {
    settingsComponent,
    keysComponent
  },
  props: {
    value: {
      type: Object,
      required: true
    },
    blocksLength: {
      type: Number,
      default: 0
    },
    position: {
      type: [Number, String],
      required: true
    },
    previousHeadingType: {
      type: [Number, String],
      default: 0
    },
    previousSameIndex: {
      type: Number,
      default: 0
    },
    nextSameIndex: {
      type: Number,
      default: null
    },
    planConfig: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      showKeys: false,
      showSettings: false
    };
  },
  methods: {
    settingsButtonVariant() {
      const settingsHasErrors = this.refsHasErrors("settings-blocks");
      return this.showSettings ? (settingsHasErrors ? "danger" : "secondary")
        : (settingsHasErrors ? "outline-danger" : "outline-secondary");
    },
    keysButtonVariant() {
      const keysHasErrors = this.refsHasErrors("keys-blocks");
      return this.showKeys ? (keysHasErrors ? "danger" : "secondary")
        : (keysHasErrors ? "outline-danger" : "outline-secondary");
    },
    refsHasErrors(refName) {
      if (refName in this.$refs) {
        return this.$refs[refName].reduce((result, $ref) => {
          return result ? true : $ref.errors.any();
        }, false);
      }
      return false;
    },
    validationName(ref) {
      let block = null;
      if (this.position === this.planConfig.headings.opening) {
        block = 'openingBlock';
      }
      return `plan.${block || `blocks.${this.position}`}.${ref}`;
    },
    addSettingsBlock() {
      this.$emit("add-settings-block", this.position);
    },
    addKeysBlock() {
      this.$emit("add-keys-block", this.position);
    },
    addChild() {
      this.$emit("add-child", this.position);
    },
    addBefore() {
      this.$emit("add-before", this.position);
    },
    addAfter() {
      this.$emit("add-after", this.position);
    },
    moveUp() {
      this.$emit("move-up", this.position, this.previousSameIndex);
    },
    moveDown() {
      this.$emit("move-down", this.position, this.nextSameIndex);
    },
    deleteBlock() {
      this.$emit("delete", this.position);
    },
    toggleShowKeys() {
      this.showKeys = !this.showKeys;
      if (this.showKeys) {
        this.showSettings = false;
      }
    },
    toggleShowSettings() {
      this.showSettings = !this.showSettings;
      if (this.showSettings) {
        this.showKeys = false;
      }
    },
    deleteSettingsBlock(index) {
      this.$delete(this.value.settings, index);
    },
    deleteKeysBlock(index) {
      this.$delete(this.value.keys, index);
    }
  },
  computed: {
    isOpening() {
      return this.position === this.planConfig.headings.opening;
    },
    isMovable() {
      return !this.isOpening;
    },
    isEditable() {
      return this.isMovable && this.value.heading;
    },
    headingOptions() {
      return this.planConfig.headings.sequence[this.previousHeadingType].all || [];
    },
    nesting() {
      if (this.blocksLength > 1 && this.value.heading > 1) {
        return this.value.heading - 2;
      }
      return 0;
    },
    hasChild() {
      return this.isEditable && this.planConfig.headings.sequence[this.value.heading].next;
    }
  }
}
