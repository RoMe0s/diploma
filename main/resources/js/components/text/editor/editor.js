import "froala-editor/js/plugins.pkgd.min.js";
import "froala-editor/css/froala_editor.pkgd.min.css";
import "froala-editor/css/themes/gray.min.css";

import VueFroala from "vue-froala-wysiwyg";

Vue.use(VueFroala);

import config from "./config.js";

export default {
  props: {
    content: {
      required: true,
      validator: prop => typeof prop === 'string' || prop === null
    }
  },
  data() {
    return {
      value: this.content
    };
  },
  methods: {
    getConfig() {
      return config;
    }
  },
  watch: {
    value: function (value) {
      this.$emit("input", value);
    }
  }
}
