<template>
    <b-card no-body>
        <b-card-header>
            {{ __('messages.chat') }}
        </b-card-header>
        <b-card-body>
            <b-list-group class="messages mb-3" ref="messages">
                <b-list-group-item v-for="(message, index) in messages" :key="'message-' + index">
                    <div v-if="message.user.id === sender.id">
                        <b-row class="mb-1">
                            <b-col cols="10">
                                <h4 class="mb-0">
                                    {{ message.user.name }}
                                </h4>
                            </b-col>
                            <b-col cols="2" align="right">
                                <b-badge variant="secondary">
                                    {{ message.created_at }}
                                </b-badge>
                            </b-col>
                        </b-row>
                        <hr class="mb-1 mt-0"/>
                        <p class="mb-0">
                            {{ message.message }}
                        </p>
                    </div>
                    <div align="right" v-else>
                        <b-row class="mb-1">
                            <b-col cols="2" align="left">
                                <b-badge variant="secondary">
                                    {{ message.created_at }}
                                </b-badge>
                            </b-col>
                            <b-col cols="10">
                                <h4 class="mb-0">
                                    {{ message.user.name }}
                                </h4>
                            </b-col>
                        </b-row>
                        <hr class="mb-1 mt-0"/>
                        <p class="mb-0">
                            {{ message.message }}
                        </p>
                    </div>
                </b-list-group-item>
            </b-list-group>
            <b-form-group class="mb-0">
                <b-form-textarea name="message" v-model="message" :placeholder="__('fields.message')"
                                 v-validate="'required|max:1000'" :state="noErrors('message')" rows="3" max-rows="5">
                </b-form-textarea>
                <b-form-invalid-feedback>
                    {{ errors.first("message") }}
                </b-form-invalid-feedback>
            </b-form-group>
        </b-card-body>
        <b-card-footer align="center">
            <b-btn variant="success" @click.prevent="send()">
                {{ __("messages.send message") }}
            </b-btn>
        </b-card-footer>
    </b-card>
</template>
<script src="./task.js"></script>
<style scoped lang="scss">
    .messages {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
