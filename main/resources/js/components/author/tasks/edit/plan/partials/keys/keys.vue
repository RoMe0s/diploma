<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title class="mb-0">
                {{ __("messages.keys") }}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-list-group>
                <b-list-group-item v-for="(key, index) in value" :key="`keys-${_uid}-${index}`">
                    <div class="float-right">
                        <b-badge variant="danger" v-if="key.type === 'strict'">
                            {{ __("messages.plan.keys.strict") }}
                        </b-badge>
                        <b-badge variant="warning" v-else>
                            {{ __("messages.plan.keys.not strict") }}
                        </b-badge>
                        <b-badge variant="primary">
                            {{ key.count }}
                        </b-badge>
                    </div>
                    {{ key.value }}
                </b-list-group-item>
            </b-list-group>
        </b-card-body>
    </b-card>
</template>
<script src="./keys.js"></script>