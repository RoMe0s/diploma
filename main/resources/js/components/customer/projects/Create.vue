<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __('customer.projects.create') }}
                <b-link class="btn btn-primary float-right" href="/projects" :title="__('messages.to list')">
                    <i class="fa fa-arrow-left"></i>
                </b-link>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form @submit.prevent="store()">
                <b-form-group :label="__('fields.name')">
                    <b-form-input name="name" v-validate="'required|max:255'" v-model="name" :state="noErrors('name')"
                                  :placeholder="__('fields.name')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first('name') }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <div class="text-center">
                    <b-button type="submit" variant="success">
                        {{ __('messages.save') }}
                    </b-button>
                </div>
            </b-form>
        </b-card-body>
    </b-card>
</template>

<script>
  export default {
    data() {
      return {
        name: null
      }
    },
    methods: {
      store() {
        this.validateAll().then(isValid => {
          if (isValid) {
            this.sendRequest('customer.projects.store', {name: this.name})
              .then(response => Swal.fire({type: 'success', title: this.__('messages.saved!')})
                .then(() => window.location.href = `/projects/${response.data.id}/edit`))
          }
        });
      }
    }
  }
</script>
