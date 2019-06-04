<template>
    <b-card no-body v-if="value">
        <b-card-header>
            <b-card-title>
                {{ __("author.tasks.edit") }} #{{ id }}
                <b-button-group class="float-right">
                    <b-link class="btn btn-primary" href="/tasks" :title="__('messages.to list')">
                        <i class="fa fa-arrow-left"></i>
                    </b-link>
                    <b-button variant="danger" @click.prevent="showCancelConfirm()" :title="__('messages.cancel')">
                        <i class="fa fa-ban"></i>
                    </b-button>
                </b-button-group>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form>
                <div align="right">
                    <b-badge variant="danger" :title="__('messages.time left')">
                        {{ value.expired_at }}
                    </b-badge>
                    <b-badge variant="primary" :title="__('messages.sizes')">
                        {{ value.order.plan.sizes.from }} - {{ value.order.plan.sizes.to }}
                    </b-badge>
                    <b-badge variant="success" :title="__('messages.prices')">
                        {{ value.order.prices.min }} - {{ value.order.prices.max }}
                    </b-badge>
                </div>
                <h2 v-if="value.order.name">
                    {{ value.order.name }}
                </h2>
                <p v-if="value.order.description">
                    {{ value.order.description }}
                </p>

                <plan-component :value="value.order.plan"/>

                <b-form-group :label="__('fields.name')" v-if="!value.order.name">
                    <b-form-input name="name" v-model="value.text.name" :placeholder="__('fields.name')"
                                  v-validate="'max:255'" :state="noErrors('name')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("name") }}
                    </b-form-invalid-feedback>
                </b-form-group>

            </b-form>
        </b-card-body>
        <b-card-footer class="text-center">
            <b-button type="submit" variant="success">
                {{ __("messages.save") }}
            </b-button>
        </b-card-footer>
    </b-card>
</template>
<script src="./edit.js"></script>