<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("messages.account info") }}
            </b-card-title>
        </b-card-header>
        <b-form @submit.prevent="save()">
            <b-card-body>
                <b-form-group :label="__('fields.email')">
                    <b-form-input type="email" name="email" v-model="email" v-validate="'required|email|max:255'"
                                  :state="noErrors('email')" :placeholder="__('fields.email')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("email") }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.name')">
                    <b-form-input name="name" v-model="name" v-validate="'required|max:255'"
                                  :state="noErrors('name')" :placeholder="__('fields.name')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("name") }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-card-body>
            <b-card-footer align="right">
                <b-button type="submit" variant="success">
                    {{ __("messages.save") }}
                </b-button>
            </b-card-footer>
        </b-form>
    </b-card>
</template>
<script src="./info.js"></script>
