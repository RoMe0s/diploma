<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("messages.orders") }}
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
                     api-url="author.orders.index"
                     :items="itemsProvider"
                     :filter="filter"
                     :fields="fields"
                     :per-page="perPage"
                     :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :current-page="currentPage"
                     :sort-direction="sortDirection">
                <template slot="size_from" slot-scope="row">
                    {{ row.item.sizes.from }}
                </template>
                <template slot="size_to" slot-scope="row">
                    {{ row.item.sizes.to }}
                </template>
                <template slot="min_price" slot-scope="row">
                    {{ row.item.prices.min }}
                </template>
                <template slot="max_price" slot-scope="row">
                    {{ row.item.prices.max }}
                </template>
                <template slot="actions" slot-scope="row">
                    <b-btn-group>
                        <b-button size="sm" variant="success" :title="__('messages.accept')"
                                  @click="append(row.item.id)">
                            <i class="far fa-check-circle"></i>
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
