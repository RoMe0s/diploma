<template>
    <b-card no-body :header="__('messages.errors')">
        <b-list-group>
            <b-list-group-item v-for="(check, index) in checks" :key="`check-${index}`">
                {{ check.translated }}
            </b-list-group-item>
        </b-list-group>
    </b-card>
</template>
<script src="./checks.js"></script>
