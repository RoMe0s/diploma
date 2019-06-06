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

            <div v-if="isEditable">
                <b-alert :show="wasChanged && contentError === null && !isEdited" variant="success" dismissible>
                    {{ __("messages.everything saved") }}
                </b-alert>
                <b-alert v-model="isEdited" variant="info">
                    {{ __("messages.changes unsaved") }}
                    <b-button type="submit" variant="primary" size="sm" @click="save()">
                        {{ __("messages.save") }}
                    </b-button>
                </b-alert>
                <b-alert :show="contentError !== null" variant="danger">
                    {{ contentError }}
                </b-alert>
                <text-editor :content="value.text.content" @input="textChanged"/>
            </div>
            <b-card bg-variant="light" :header="__('messages.text preview')" no-body v-else>
                <b-card-body v-html="value.text.content"/>
            </b-card>
        </b-card-body>
        <b-card-footer class="text-center">
            <b-button variant="success" @click="sendToCheck()">
                {{ __("messages.send to check") }}
            </b-button>
        </b-card-footer>
    </b-card>
</template>
<script src="./edit.js"></script>