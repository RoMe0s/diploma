<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("customer.tasks.index") }}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form-group label-cols-sm="3" :label="__('messages.filter')">
                <b-input-group>
                    <b-form-input v-model="filter" :placeholder="__('messages.type to search')"/>
                </b-input-group>
            </b-form-group>

            <b-table show-empty
                     ref="table"
                     stacked="md"
                     bordered
                     api-url="customer.tasks.index"
                     :items="itemsProvider"
                     :filter="filter"
                     :fields="fields"
                     :per-page="perPage"
                     :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :current-page="currentPage"
                     :sort-direction="sortDirection">
                <template slot="status" slot-scope="row">
                    <b-badge variant="info">
                        {{ __(`messages.task.status.${row.item.status}`) }}
                    </b-badge>
                </template>
                <template slot="expired_at" slot-scope="row">
                    <b-badge variant="danger" v-if="row.item.has_expired_at">
                        {{ row.item.expired_at }}
                    </b-badge>
                    <b-badge variant="secondary" v-else>
                        {{ __('messages.not applicated') }}
                    </b-badge>
                </template>
                <template slot="actions" slot-scope="row">
                    <b-btn-group>
                        <b-link class="btn btn-sm btn-secondary" :href="`/checks/${row.item.id}`"
                                :title="__('messages.show')">
                            <i class="fa fa-eye"></i>
                        </b-link>
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
                    <b-pagination align="right"
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
<script src="./index.js"></script>
