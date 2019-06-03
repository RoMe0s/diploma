<template>
    <b-card no-body v-if="value">
        <b-card-header>
            <b-card-title>
                {{ __("author.tasks.edit") }} #{{ id }}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form>
                <div align="right">
                    <b-badge variant="danger" :title="__('messages.time left')">
                        {{ value.expired_at }}
                    </b-badge>
                    <b-badge variant="primary" :title="__('messages.sizes')">
                        {{ value.order.sizes.from }} - {{ value.order.sizes.to }}
                    </b-badge>
                    <b-badge variant="success" :title="__('messages.prices')">
                        {{ value.order.price.min }} - {{ value.order.price.max }}
                    </b-badge>
                </div>
                <h2 v-if="value.order.name">
                    {{ value.order.name }}
                </h2>
                <p v-if="value.order.description">
                    {{ value.order.description }}
                </p>
                <b-form-group :label="__('fields.name')" v-if="!value.order.name">
                    <b-form-input name="name" v-model="value.name" :placeholder="__('fields.name')"
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