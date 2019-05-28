<template>
    <b-card no-body>
        <b-card-header>
            <b-card-title>
                {{ __("messages.change password") }}
            </b-card-title>
        </b-card-header>
        <b-form @submit.prevent="change()">
            <b-card-body>
                <b-form-group :label="__('fields.password')">
                    <b-form-input type="password" name="password" v-validate="'required|min:8'" v-model="password"
                                  :state="noErrors('password')" :placeholder="__('fields.password')" ref="password"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("password") }}
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group :label="__('fields.password confirmation')">
                    <b-form-input type="password" name="password_confirmation"
                                  v-validate="'required|confirmed:password'" v-model="password_confirmation"
                                  :state="noErrors('password_confirmation')"
                                  :placeholder="__('fields.password confirmation')"/>
                    <b-form-invalid-feedback>
                        {{ errors.first("password_confirmation") }}
                    </b-form-invalid-feedback>
                </b-form-group>
            </b-card-body>
            <b-card-footer align="right">
                <b-button type="submit" variant="success">
                    {{ __("messages.change") }}
                </b-button>
            </b-card-footer>
        </b-form>
    </b-card>
</template>
<script src="./password.js"></script>
