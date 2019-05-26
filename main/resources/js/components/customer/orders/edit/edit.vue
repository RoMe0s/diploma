<template>
    <b-card no-body v-if="value">
        <b-card-header>
            <b-card-title>
                {{ __("customer.orders.edit") }} #{{ id }}
                <b-button-group class="float-right">
                    <b-link class="btn btn-primary" href="/orders" :title="__('messages.to list')">
                        <i class="fa fa-arrow-left"></i>
                    </b-link>
                    <b-button variant="danger" @click.prevent="showDeleteConfirm()"
                              :title="__('messages.delete')">
                        <i class="fa fa-trash"></i>
                    </b-button>
                </b-button-group>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form @submit.prevent="update()">
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
<script src="./edit.js"></script>
