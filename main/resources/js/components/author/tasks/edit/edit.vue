<template>
    <b-card no-body v-if="value">
        <b-card-header>
            <b-card-title>
                {{ __("messages.edit") }} #{{ id }}
                <b-button-group class="float-right">
                    <b-link class="btn btn-primary" href="/tasks" :title="__('messages.to list')">
                        <i class="fa fa-arrow-left"></i>
                    </b-link>
                    <b-button variant="danger" @click.prevent="showCancelConfirm()" :title="__('messages.cancel')"
                              v-if="isEditable">
                        <i class="fa fa-ban"></i>
                    </b-button>
                </b-button-group>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <div align="right">
                <b-badge variant="info" :title="__('messages.task.status.' + value.status)">
                    {{ __('messages.task.status.' + value.status) }}
                </b-badge>
                <b-badge variant="danger" :title="__('messages.time left')" v-if="value.expired_at">
                    {{ value.expired_at }}
                </b-badge>
                <b-badge variant="primary" :title="__('messages.sizes')">
                    {{ value.order.plan.sizes.from }} - {{ value.order.plan.sizes.to }}
                </b-badge>
                <b-badge variant="success" :title="__('messages.prices')">
                    {{ value.order.prices.min }} - {{ value.order.prices.max }}
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

            <div v-show="isEditable">
                <b-alert :show="wasChanged && contentError === null && !isEdited" variant="success" dismissible>
                    {{ __("messages.everything is saved") }}
                </b-alert>
                <b-alert v-model="isEdited" variant="info">
                    {{ __("messages.changes is unsaved") }}
                    <b-button type="submit" variant="primary" size="sm" @click="save()">
                        {{ __("messages.save") }}
                    </b-button>
                </b-alert>
                <b-alert :show="contentError !== null" variant="danger">
                    {{ contentError }}
                </b-alert>
                <text-editor :content="value.text.content" @input="textChanged"/>
                <checks-component :checks="value.checks" v-if="value.checks.length" class="mt-3"/>
            </div>

            <b-card bg-variant="light" :header="__('messages.text preview')" no-body v-if="!isEditable">
                <b-card-body v-html="value.text.content"/>
            </b-card>

            <chat-task :id="id" load-route="author.tasks.chat.load" send-route="author.tasks.chat.send"
                       class="mt-3"></chat-task>
        </b-card-body>
        <b-card-footer class="text-center" v-if="isEditable">
            <b-button variant="success" @click="save()" v-if="isEdited">
                {{ __("messages.save") }}
            </b-button>
            <b-button variant="success" @click="sendToCheck()" v-else>
                {{ __("messages.send to check") }}
            </b-button>
        </b-card-footer>
    </b-card>
</template>
<script src="./edit.js"></script>
