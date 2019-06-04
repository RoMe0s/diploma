import KeysComponent from "../keys/keys.vue";
import SettingsComponent from "../settings/settings.vue";

export default {
  components: {
    KeysComponent,
    SettingsComponent
  },
  props: {
    value: {
      type: Object,
      required: true
    }
  }
}