<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("customer.orders.create") }}
                <b-link class="btn btn-primary float-right" href="/orders" :title="__('messages.to list')">
                    <i class="fa fa-arrow-left"></i>
                </b-link>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form @submit.prevent="store()">
                <form-component v-model="value"/>
                <div class="text-center mt-3">
                    <b-button type="submit" variant="success">
                        {{ __("messages.save") }}
                    </b-button>
                </div>
            </b-form>
        </b-card-body>
    </b-card>
</template>

<script>
  import FormComponent from "./form/form.vue";

  export default {
    components: {
      FormComponent
    },
    data() {
      return {
        value: {
          description: null,
          project_id: null,
          plan: {
            sizes: {from: "0", to: null},
            openingBlock: null,
            closingBlock: null,
            blocks: []
          },
          name: null,
          price: null
        }
      }
    },
    methods: {
      store() {
        this.validateAll().then(() => {
          this.sendRequest("customer.orders.store", this.value)
            .then(response => Swal.fire({type: "success", title: this.__("messages.saved!")})
              .then(() => window.location.href = `/orders/${response.data.id}/edit`));
        });
      }
    }
  }
</script>
