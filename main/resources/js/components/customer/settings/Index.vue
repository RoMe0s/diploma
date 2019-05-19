<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __('customer.settings.index') }}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-table
                bordered
                show-empty
                ref="table"
                stacked="md"
                api-url="customer.settings.index"
                :items="itemsProvider"
                :fields="fields">
                <template slot="key" slot-scope="row">
                    <b-form-group label-cols-sm="6" :label="__(`checks.${row.item.key}.title`)" label-size="lg"
                                  class="mb-0">
                        <component :is="getFormComponent(row.item)" :value="row.item.value" :check="row.item.key"
                                   @delete-clicked="showDeleteConfirm(row.item.key)"
                                   @update-or-create="updateOrCreate"
                                   @info-clicked="row.toggleDetails"/>
                    </b-form-group>
                </template>
                <template slot="row-details" slot-scope="row">
                    <p class="mb-0 text-center">{{ __(`checks.${row.item.key}.description`) }}</p>
                </template>
            </b-table>
        </b-card-body>
    </b-card>
</template>

<script>
  import ProviderMixin from "../../../mixins/table/provider";
  import DeleteConfirmMixin from "../../../mixins/deleteConfirm";
  import NumericForm from "./forms/Numeric";
  import BooleanForm from "./forms/Boolean";
  import PercentForm from "./forms/Percent";

  export default {
    mixins: [ProviderMixin, DeleteConfirmMixin],
    data() {
      return {
        fields: [
          {
            key: 'key',
            label: this.__('columns.key')
          }
        ]
      }
    },
    methods: {
      itemsProviderCallback(response) {
        return response.data;
      },
      showDeleteConfirm(check) {
        this.deleteConfirm(() => {
          this.sendRequest('customer.settings.destroy', check)
            .then(() => {
              this.$refs.table.refresh();
              Swal.fire({
                title: this.__('messages.deleted!'),
                type: 'success'
              });
            });
        });
      },
      getFormComponent(check) {
        switch (check.type) {
          case 'numeric':
            return NumericForm;
          case 'boolean':
            return BooleanForm;
          case 'percent':
            return PercentForm;
        }
      },
      updateOrCreate(check, value, $children = null) {
        const validatedCallback = $instance => $instance.sendRequest('customer.settings.update-or-create', [check, value])
          .then(() => this.notify(this.__('messages.saved!'), 'success'));
        if ($children === null) {
          validatedCallback(this);
          return;
        }
        $children.validate(check).then(() => validatedCallback($children));
      }
    }
  }
</script>