<template>
    <b-card no-body :header="__('messages.settings')">
        <b-list-group>
            <b-list-group-item class="d-flex justify-content-between align-items-center"
                               v-for="(setting, index) in settings" :key="`setting-${index}`">
                {{ __(`checks.${setting.key}.title`) }}
                <b-badge variant="success" pill v-if="setting.value === true">
                    {{ __('messages.yes') }}
                </b-badge>
                <b-badge variant="danger" pill v-else-if="setting.value === false">
                    {{ __('messages.no') }}
                </b-badge>
                <b-badge variant="primary" pill v-else>
                    {{ setting.value }}
                </b-badge>
            </b-list-group-item>
        </b-list-group>
    </b-card>
</template>
<script src="./settings.js"></script>
