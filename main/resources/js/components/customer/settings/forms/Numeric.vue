<template>
    <b-input-group>
        <b-form-input type="number" min="0" :name="check" v-model="localValue" @change="save"
                      :placeholder="__(`checks.${check}.title`)" v-validate="'integer|min_value:0'"
                      :state="noErrors(check)" :data-vv-as="__('messages.value')"/>

        <b-input-group-append>
            <b-button variant="outline-danger" @click="$emit('delete-clicked')" v-if="value !== null">
                <i class="fa fa-minus-circle"></i>
            </b-button>
            <b-button variant="outline-info" @click="$emit('info-clicked')">
                <i class="fa fa-info"></i>
            </b-button>
        </b-input-group-append>

        <b-form-invalid-feedback>
            {{ errors.first(check) }}
        </b-form-invalid-feedback>
    </b-input-group>
</template>
<script>
  export default {
    props: {
      value: {
        type: Number,
        default: null
      },
      check: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        localValue: this.value
      }
    },
    methods: {
      save(value) {
        value = value ? parseInt(value) : null;
        this.$emit('update-or-create', this.check, value, this);
      }
    },
    watch: {
      value(value) {
        this.localValue = value;
      }
    }
  }
</script>