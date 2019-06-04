<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title class="mb-0">
                {{ __("messages.setting blocks") }}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-list-group>
                <b-list-group-item v-for="(setting, index) in value" :key="`settings-${_uid}-${index}`">
                    <div class="float-right">
                        <b-badge variant="primary">
                            {{ setting.min }} - {{ setting.max }}
                        </b-badge>
                    </div>
                    {{ __(`messages.plan.settings.${setting.type}`) }}
                </b-list-group-item>
            </b-list-group>
        </b-card-body>
    </b-card>
</template>
<script src="./settings.js"></script>