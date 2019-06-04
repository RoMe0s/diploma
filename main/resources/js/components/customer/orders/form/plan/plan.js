import DeleteConfirmMixin from "../../../../../mixins/deleteConfirm.js"
import BlockComponent from "./partials/block/block.vue"
import {blockSchema} from "../../../../../helpers/plan"

export default {
  mixins: [DeleteConfirmMixin],
  components: {
    BlockComponent
  },
  props: {
    value: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      useOpeningBlock: this.value.openingBlock !== null,
      useClosingBlock: this.value.closingBlock !== null,
      planConfig: null,
      lastUid: 1
    }
  },
  methods: {
    settingsBlockSchema() {
      return {
        type: null,
        min: null,
        max: null
      };
    },
    keysBlockSchema() {
      return {
        value: null,
        type: null,
        count: null
      };
    },
    addSettingsBlock(index, block = null) {
      (block || this.value.blocks[index]).settings.push(this.settingsBlockSchema());
    },
    addKeysBlock(index, block = null) {
      (block || this.value.blocks[index]).keys.push(this.keysBlockSchema());
    },
    addChild(index) {
      const nextHeading = this.planConfig.headings.sequence[this.value.blocks[index].heading].next || null;
      const block = {...blockSchema(this.getBlockUid()), heading: nextHeading};
      if (this.blocksLength === ++index) {
        this.value.blocks.push(block);
      } else {
        for (; index < this.blocksLength; index++) {
          if (this.value.blocks[index].heading < nextHeading) {
            break;
          }
        }
        if (this.blocksLength === index) {
          this.value.blocks.push(block);
        } else {
          this.value.blocks.splice(index, 0, block);
        }
      }
    },
    addBefore(index) {
      const heading = this.value.blocks[index].heading;
      const block = {...blockSchema(this.getBlockUid()), heading};
      this.value.blocks.splice(index, 0, block);
    },
    addAfter(index) {
      const heading = this.value.blocks[index].heading;
      if (heading > 1) {
        const block = {...blockSchema(this.getBlockUid()), heading};
        const endOfSection = this.endOfSectionAfter(index);
        if (endOfSection) {
          this.value.blocks.splice(endOfSection, 0, block);
        } else {
          this.value.blocks.push(block);
        }
      } else {
        this.addChild(index);
      }
    },
    deleteBlock(index) {
      if (this.blocksLength > 1) {
        this.deleteConfirm(() => this.value.blocks.splice(index, 1));
      }
    },
    moveDown(index, nextIndex) {
      let nextNextIndex = nextIndex + 1;
      if (this.blocksLength > nextNextIndex) {
        nextNextIndex = this.endOfSectionAfter(nextIndex);
        if (!nextNextIndex) {
          nextNextIndex = this.blocksLength;
        }
      }
      this.resetValidationRecursive();
      this.value.blocks.splice(
        index,
        nextNextIndex - index,
        ...this.value.blocks.slice(nextIndex, nextNextIndex),
        ...this.value.blocks.slice(index, nextIndex)
      );
    },
    moveUp(index, prevIndex) {
      let nextIndex = index + 1;
      if (this.blocksLength > nextIndex) {
        nextIndex = this.endOfSectionAfter(index);
        if (!nextIndex) {
          nextIndex = this.blocksLength;
        }
      }
      this.resetValidationRecursive();
      this.value.blocks.splice(
        prevIndex,
        nextIndex - prevIndex,
        ...this.value.blocks.slice(index, nextIndex),
        ...this.value.blocks.slice(prevIndex, index)
      );
    },
    previousHeadingType(index) {
      if (index > 0) {
        const currentHeading = this.value.blocks[index].heading || null;
        if (currentHeading && currentHeading > 2) {
          return currentHeading - 1;
        }
        return this.value.blocks[index - 1].heading || this.planConfig.headings.opening;
      }
      return 0;
    },
    endOfSectionAfter(index) {
      const heading = this.value.blocks[index++].heading;
      if (heading) {
        for (; index < this.blocksLength; index++) {
          if (this.value.blocks[index].heading < heading
            || this.value.blocks[index].heading === heading) {
            return index;
          }
        }
      }
      return null;
    },
    endOfSectionBefore(index) {
      const heading = this.value.blocks[index--].heading;
      if (heading) {
        for (; index >= 0; index--) {
          if (this.value.blocks[index].heading < heading
            || this.value.blocks[index].heading === heading) {
            return index;
          }
        }
      }
      return null;
    },
    previousSameIndex(index) {
      const endOfSection = this.endOfSectionBefore(index);
      if (endOfSection !== null && this.value.blocks[index].heading === this.value.blocks[endOfSection].heading) {
        return endOfSection;
      }
      return null;
    },
    nextSameIndex(index) {
      const endOfSection = this.endOfSectionAfter(index);
      if (endOfSection && this.value.blocks[index].heading === this.value.blocks[endOfSection].heading) {
        return endOfSection;
      }
      return null;
    },
    getBlockUid() {
      return ++this.lastUid;
    },
    blockUid(block) {
      if ("uid" in block) {
        return block.uid;
      }
      const uid = this.getBlockUid();
      this.$set(block, "uid", uid);
      return uid;
    },
    toggleUseOpeningBlock() {
      this.useOpeningBlock = !this.useOpeningBlock;
      this.$set(this.value, "openingBlock", this.useOpeningBlock ? blockSchema(this.planConfig.headings.opening) : null);
    },
    toggleUseClosingBlock() {
      this.useClosingBlock = !this.useClosingBlock;
      this.$set(this.value, "closingBlock", this.useClosingBlock ? blockSchema(this.planConfig.headings.closing) : null);
    }
  },
  computed: {
    blocksLength() {
      return this.value.blocks.length;
    }
  },
  created() {
    this.sendRequest("config.plan")
      .then(response => this.planConfig = response.data)
  }
}