<template>
    <b-card no-body v-if="value">
        <b-card-header>
            <b-card-title>
                {{ __("messages.edit") }} #{{ id }}
                <b-button-group class="float-right">
                    <b-link class="btn btn-primary" href="/orders" :title="__('messages.to list')">
                        <i class="fa fa-arrow-left"></i>
                    </b-link>
                    <b-button size="sm" variant="success" @click.prevent="showPublishConfirm()"
                              v-if="value.can_be_published">
                        <i class="fa fa-play"></i>
                    </b-button>
                    <b-button size="sm" variant="warning" @click.prevent="showRollbackConfirm()"
                              v-if="value.can_be_rolled_back">
                        <i class="fa fa-stop"></i>
                    </b-button>
                    <b-button variant="danger" @click.prevent="showDeleteConfirm()"
                              :title="__('messages.delete')" v-if="value.can_be_published">
                        <i class="fa fa-trash"></i>
                    </b-button>
                </b-button-group>
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form @submit.prevent="update()" v-if="value.can_be_published">
                <form-component v-model="value"/>
                <div class="text-center mt-3">
                    <b-button type="submit" variant="success">
                        {{ __("messages.save") }}
                    </b-button>
                </div>
            </b-form>
            <form-component v-model="value" v-else/>
        </b-card-body>
    </b-card>
</template>
<script src="./edit.js"></script>