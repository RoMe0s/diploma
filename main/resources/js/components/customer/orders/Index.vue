<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("customer.orders.index") }}
                <b-link class="btn btn-success float-right" href="/orders/create" :title="__('messages.create')">
                    <i class="fa fa-plus"></i>
                </b-link>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-row>
                <b-col md="11">
                    <b-form-group label-cols-sm="3" label="Filter">
                        <b-input-group>
                            <b-form-input v-model="filter" :placeholder="__('messages.type to search')"/>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="1">
                    <b-button block variant="danger" :title="__('messages.delete selected')"
                              :disabled="!selected.length" @click.prevent="deleteSelected()">
                        <i class="fa fa-dumpster"></i>
                    </b-button>
                </b-col>
            </b-row>

            <b-table
                show-empty
                ref="table"
                stacked="md"
                selectable
                bordered
                api-url="customer.orders.index"
                :items="itemsProvider"
                :filter="filter"
                :fields="fields"
                :per-page="perPage"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :current-page="currentPage"
                :sort-direction="sortDirection"
                @row-selected="rowSelected">
                <template slot="name" slot-scope="row">
                    <span v-if="row.item.name">
                        {{ row.item.name }}
                    </span>
                    <b-badge variant="secondary" v-else>
                        {{ __('messages.not applicated') }}
                    </b-badge>
                </template>
                <template slot="status" slot-scope="row">
                    <b-badge variant="info">
                        {{ __(`messages.order.status.${row.item.status}`) }}
                    </b-badge>
                </template>
                <template slot="actions" slot-scope="row">
                    <b-btn-group>
                        <b-button size="sm" variant="success" @click.prevent="showPublishConfirm(row.item.id)"
                                  v-if="row.item.can_be_published">
                            <i class="fa fa-play"></i>
                        </b-button>
                        <b-button size="sm" variant="warning" @click.prevent="showRollbackConfirm(row.item.id)"
                                  v-if="row.item.can_be_rolled_back">
                            <i class="fa fa-stop"></i>
                        </b-button>
                        <b-link class="btn btn-sm btn-info" :href="`/orders/${row.item.id}/edit`"
                                :title="__('messages.edit')">
                            <i class="fa fa-pencil-alt"></i>
                        </b-link>
                        <b-button size="sm" variant="danger" @click.prevent="showDeleteConfirm(row.item.id)"
                                  :title="__('messages.delete')" v-if="row.item.can_be_published">
                            <i class="fa fa-trash"></i>
                        </b-button>
                    </b-btn-group>
                </template>
            </b-table>

            <b-row v-if="totalRows">
                <b-col md="5">
                    <b-form-group label-cols-sm="3" :label="__('messages.per page')" class="mb-0">
                        <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col md="7">
                    <b-pagination
                        align="right"
                        class="mb-0"
                        v-model="currentPage"
                        :total-rows="totalRows"
                        :per-page="perPage">
                    </b-pagination>
                </b-col>
            </b-row>

        </b-card-body>
    </b-card>
</template>

<script>
  import ProviderMixin from "../../../mixins/table/provider";
  import DeleteConfirmMixin from "../../../mixins/deleteConfirm";

  export default {
    mixins: [ProviderMixin, DeleteConfirmMixin],
    data() {
      return {
        fields: [
          {
            key: "id",
            sortable: true,
            label: this.__("columns.id")
          },
          {
            key: "name",
            sortable: true,
            label: this.__("columns.name")
          },
          {
            key: "price",
            sortable: true,
            label: this.__("columns.price")
          },
          {
            key: "status",
            sortable: true,
            label: this.__("columns.status")
          },
          {
            key: "date",
            sortable: true,
            label: this.__("columns.changed at")
          },
          {
            key: "actions",
            label: this.__("columns.actions")
          }
        ],
        perPage: 25,
        filter: null,
        sortBy: null,
        totalRows: 0,
        currentPage: 1,
        sortDesc: false,
        sortDirection: "desc",
        pageOptions: [25, 50, 100],
        selected: [],
        deletedCallback: () => {
          this.$refs.table.refresh();
          Swal.fire({
            title: this.__("messages.deleted!"),
            type: "success"
          });
        }
      }
    },
    methods: {
      rowSelected(items) {
        this.selected = _.values(_.mapValues(items, "id"));
      },
      showDeleteConfirm(id) {
        this.deleteConfirm(() => {
          this.sendRequest("customer.orders.destroy", id)
            .then(this.deletedCallback);
        });
      },
      deleteSelected() {
        this.deleteConfirm(() => {
          this.sendRequest("customer.orders.index-action", {
            orders: this.selected,
            action: "delete"
          }).then(this.deletedCallback)
        })
      },
      showPublishConfirm(id) {
        Swal.fire({
          title: this.__("messages.are you sure?"),
          showCancelButton: true,
          type: "success",
          confirmButtonText: this.__("messages.publish order"),
          cancelButtonText: this.__("messages.cancel")
        }).then(answer => {
          if (answer.value === true) {
            this.sendRequest("customer.orders.publish", id, error => {
              Swal.fire({
                text: _.join(_.flattenDeep(_.values(error.response.data.errors)), "\n"),
                title: this.__("messages.error"),
                type: "error"
              })
            }).then(() => {
              this.$refs.table.refresh();
              Swal.fire({
                title: this.__("messages.published!"),
                type: "success"
              });
            })
          }
        });
      },
      showRollbackConfirm(id) {
        Swal.fire({
          title: this.__("messages.are you sure?"),
          showCancelButton: true,
          type: "warning",
          confirmButtonText: this.__("messages.rollback order"),
          cancelButtonText: this.__("messages.cancel")
        }).then(answer => {
          if (answer.value === true) {
            this.sendRequest("customer.orders.rollback", id)
              .then(() => {
                this.$refs.table.refresh();
                Swal.fire({
                  title: this.__("messages.rolled back!"),
                  type: "success"
                });
              })
          }
        });
      },
      itemsProviderCallback(response) {
        this.totalRows = response.data.totalRows;
        return response.data.rows;
      }
    }
  }
</script>