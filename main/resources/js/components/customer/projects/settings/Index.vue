<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __('customer.projects.settings.index') }} "{{ project.name }}"
                <b-button-group class="float-right">
                    <b-link class="btn btn-primary" :href="`/projects/${project.id}/edit`"
                            :title="__('messages.to list')">
                        <i class="fa fa-arrow-left"></i>
                    </b-link>
                </b-button-group>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-table
                bordered
                show-empty
                ref="table"
                stacked="md"
                api-url="customer.projects.settings.index"
                :items="itemsProvider"
                :fields="fields">
                <template slot="key" slot-scope="row">
                    <b-form-group label-cols-sm="6" :label="__(`checks.${row.item.key}.title`)" label-size="lg"
                                  class="mb-0">
                        <component :is="getFormComponent(row.item)" :value="row.item.value" :check="row.item.key"
                                   @delete-clicked="showDeleteConfirm(row.item)"
                                   @update-or-create="updateOrCreate($event, row.item)"
                                   @info-clicked="row.toggleDetails" :ref="row.item.key"/>
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
  import DeleteConfirmMixin from "../../../../mixins/deleteConfirm";
  import NumericForm from '../../settings/forms/Numeric';
  import BooleanForm from '../../settings/forms/Boolean';
  import PercentForm from '../../settings/forms/Percent';

  export default {
    mixins: [DeleteConfirmMixin],
    props: {
      project: {
        type: Object,
        required: true
      }
    },
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
      itemsProvider(ctx) {
        return this.sendRequest(ctx.apiUrl, [this.project.id, {
          filter: ctx.filter,
          sortBy: ctx.sortBy,
          sortDesc: +ctx.sortDesc,
          perPage: ctx.perPage,
          currentPage: ctx.currentPage
        }], () => []).then(response => response.data);
      },
      showDeleteConfirm(record) {
        this.deleteConfirm(() => {
          this.sendRequest('customer.settings.destroy', record.key)
            .then(() => {
              this.$set(record, 'value', null);
              this.$refs[record.key].resetValidation();
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
      updateOrCreate(value, record) {
        this.sendRequest('customer.settings.update-or-create', [record.key, value])
          .then(() => {
            this.notify(this.__('messages.saved!'), 'success');
            this.$set(record, 'value', value);
          });
      }
    }
  }
</script>