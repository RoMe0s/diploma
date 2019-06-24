<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("messages.done tasks") }}
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
                     api-url="author.tasks.done"
                     :items="itemsProvider"
                     :filter="filter"
                     :fields="fields"
                     :per-page="perPage"
                     :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :current-page="currentPage"
                     :sort-direction="sortDirection">
                <template slot="actions" slot-scope="row">
                    <b-link class="btn btn-sm btn-secondary" :href="`/tasks/${row.item.id}/edit`"
                            :title="__('messages.show')">
                        <i class="fa fa-eye"></i>
                    </b-link>
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
<script src="./done.js"></script>
