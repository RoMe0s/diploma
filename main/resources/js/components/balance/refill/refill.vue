<template>
    <b-card :header="__('messages.refill form')" no-body>
        <b-card-body>
            <b-form-group>
                <b-form-input name="amount" v-model="amount" v-validate="'required|numeric|min_value:0'"
                              :state="noErrors('amount')" :placeholder="__('fields.amount')"/>
                <b-form-invalid-feedback>
                    {{ errors.first('amount') }}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group>
                <b-form-input name="exp_month" v-model="exp_month"
                              v-validate="'required|length:2|min_value:0|max_value:12'" :state="noErrors('exp_month')"
                              :placeholder="__('fields.expiration month')"
                              :data-vv-as="__('fields.expiration month')"/>
                <b-form-invalid-feedback>
                    {{ errors.first('exp_month') }}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group>
                <b-form-input name="exp_year" v-model="exp_year" v-validate="'required|length:2'"
                              :state="noErrors('exp_year')" :placeholder="__('fields.expiration year')"
                              :data-vv-as="__('fields.expiration year')"/>
                <b-form-invalid-feedback>
                    {{ errors.first('exp_year') }}
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group>
                <b-form-input name="cvv" v-model="cvv" v-validate="'required|length:3'" :state="noErrors('cvv')"
                              :placeholder="__('fields.cvv')"/>
                <b-form-invalid-feedback>
                    {{ errors.first('cvv') }}
                </b-form-invalid-feedback>
            </b-form-group>
        </b-card-body>
        <b-card-footer align="center">
            <b-button variant="success" @click="showConfirm()">
                {{ __("messages.refill") }}
            </b-button>
        </b-card-footer>
    </b-card>
</template>
<script src="./refill.js"></script>
