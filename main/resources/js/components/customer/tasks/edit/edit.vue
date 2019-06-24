<template>
    <b-card no-body v-if="value">
        <b-card-header>
            <b-card-title>
                {{ __("customer.tasks.edit") }} #{{ id }}
                <b-button-group class="float-right">
                    <b-link class="btn btn-primary" href="/checks" :title="__('messages.to list')">
                        <i class="fa fa-arrow-left"></i>
                    </b-link>
                </b-button-group>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <div align="right">
                <b-badge variant="secondary" :title="__('messages.price')">
                    {{ __('messages.price') }}: {{ value.price }}
                </b-badge>
                <b-badge variant="primary" :title="__('messages.sizes')">
                    {{ value.order.plan.sizes.from }} - {{ value.order.plan.sizes.to }}
                </b-badge>
            </div>
            <h2>
                {{ value.order.name }}
            </h2>
            <p v-if="value.order.description">
                {{ value.order.description }}
            </p>

            <plan-component :value="value.order.plan"/>

            <settings-component :settings="value.settings" class="mb-3" v-if="value.settings.length"/>

            <b-card bg-variant="light" :header="__('messages.text preview')" no-body>
                <b-card-body v-html="value.text.content"/>
            </b-card>

            <chat-task :id="id" load-route="customer.tasks.chat.load" send-route="customer.tasks.chat.send"
                       class="mt-3"></chat-task>
        </b-card-body>
        <b-card-footer class="text-center">
            <b-btn-group>
                <b-btn variant="danger" @click.prevent="showRollbackConfirm()">
                    {{ __("messages.rollback") }}
                </b-btn>
                <b-btn variant="success" @click.prevent="showAcceptConfirm()">
                    {{ __("messages.accept") }}
                </b-btn>
            </b-btn-group>
        </b-card-footer>
    </b-card>
</template>
<script src="./edit.js"></script>
