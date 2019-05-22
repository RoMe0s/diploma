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
                <b-form-group :label="__('fields.name')">
                    <b-form-input name="name" v-model="name" :placeholder="__('fields.name')"
                                  v-validate="'max:255'" :state="noErrors('name')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("name") }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.description')">
                    <b-form-textarea name="description" v-model="description" :placeholder="__('fields.description')"
                                     v-validate="'max:10000'" :state="noErrors('description')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("description") }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-row class="mb-3">
                    <b-col>
                        <b-button block variant="outline-danger" @click="clearPlan()" :disabled="!hasBlocks">
                            {{ __("messages.clear plan") }}
                        </b-button>
                    </b-col>
                    <b-col>
                        <b-button block variant="outline-primary" @click="initPlan()" :disabled="hasBlocks">
                            {{ __("messages.init plan") }}
                        </b-button>
                    </b-col>
                </b-form-row>
                <plan-component v-model="plan"/>
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
  import DeleteConfirmMixin from "../../../mixins/deleteConfirm";
  import PlanComponent from "../../plan/plan.vue";
  import {blockSchema} from "../../../helpers/plan";

  export default {
    mixins: [DeleteConfirmMixin],
    components: {
      PlanComponent
    },
    data() {
      return {
        plan: {
          sizes: {from: 0, to: null},
          openingBlock: null,
          closingBlock: null,
          allowBlocks: false,
          blocks: []
        },
        name: null,
        description: null
      }
    },
    methods: {
      store() {
        this.validateAll().then(() => {
          const data = {name: this.name, description: this.description, plan: this.plan};
          this.sendRequest("customer.orders.store", data).then(response => {
            /* Swal.fire({type: "success", title: this.__("messages.saved!")}) */
            /* .then(() => window.location.href = `/orders/${response.data.id}/edit`); */
          });
        });
      },
      initPlan() {
        this.plan.blocks.push(blockSchema());
      },
      clearPlan() {
        this.deleteConfirm(() => this.plan.blocks.splice(0, this.plan.blocks.length));
      }
    },
    computed: {
      hasBlocks() {
        return this.plan.blocks.length ? true : false;
      }
    }
  }
</script>
