<template>
    <b-card no-body>
        <b-card-header v-if="value.name">
            <b-card-title class="mb-0">
                {{ value.name}}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <div align="right">
                <b-badge variant="danger" v-if="value.heading > 0">
                    {{ __("messages.heading") }} {{ value.heading }}
                </b-badge>
                <b-badge variant="primary" :title="__('messages.sizes')">
                    {{ value.sizes.from }} - {{ value.sizes.to }}
                </b-badge>
            </div>
            <p v-if="value.description">
                {{ value.description }}
            </p>
            <b-row v-if="value.keys.length || value.settings.length">
                <b-col v-if="value.keys.length" class="mb-3">
                    <keys-component :value="value.keys"/>
                </b-col>
                <b-col v-if="value.settings.length">
                    <settings-component :value="value.settings"/>
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</template>
<script src="./block.js"></script>