<template>
    <div align="center">
        <b-btn-group>
            <b-btn :variant="value === true ? 'success': 'outline-secondary'" @click.prevent="toggle(true)">
                {{ __('messages.yes') }}
            </b-btn>
            <b-btn variant="outline-danger" @click="$emit('delete-clicked')" v-if="value !== null">
                <i class="fa fa-minus-circle"></i>
            </b-btn>
            <b-btn :variant="value === false ? 'success': 'outline-secondary'" @click.prevent="toggle(false)">
                {{ __('messages.no') }}
            </b-btn>
            <b-btn variant="outline-info" @click="$emit('info-clicked')">
                <i class="fa fa-info"></i>
            </b-btn>
        </b-btn-group>
    </div>
</template>
<script>
  export default {
    props: {
      value: {
        type: Boolean,
        default: null
      },
      check: {
        type: String,
        required: true
      }
    },
    methods: {
      toggle(status) {
        this.$emit('input', status);
        this.$emit('update-or-create', this.check, status);
      }
    }
  }
</script>