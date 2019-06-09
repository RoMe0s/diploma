<template>
    <b-card :header="__('messages.withdraw form')" no-body>
        <b-card-body>
            <b-form-group>
                <b-form-input name="amount" v-model="amount" v-validate="'required|numeric|min_value:0'"
                              :state="noErrors('amount')" :placeholder="__('messages.amount')"/>
                <b-form-invalid-feedback>
                    {{ errors.first('amount') }}
                </b-form-invalid-feedback>
            </b-form-group>
        </b-card-body>
        <b-card-footer align="center">
            <b-button variant="success" @click="showConfirm()">
                {{ __("messages.withdraw funds") }}
            </b-button>
        </b-card-footer>
    </b-card>
</template>
<script src="./withdraw.js"></script>
