<template>
    <b-card class="mt-3" no-body>
        <b-card-header>
            <b-card-title>
                {{ __("messages.balance") }}
            </b-card-title>
        </b-card-header>
        <b-card-body>
            <b-form-group>
                <b-input-group>
                    <b-form-input name="bill" v-model="bill" v-validate="'required|credit_card'"
                                  :state="noErrors('bill')" :placeholder="__('fields.bill')"/>
                    <b-input-group-append>
                        <b-button variant="success" @click.prevent="update()">
                            {{ __("messages.save") }}
                        </b-button>
                    </b-input-group-append>
                    <b-form-invalid-feedback>
                        {{ errors.first("bill") }}
                    </b-form-invalid-feedback>
                </b-input-group>
            </b-form-group>
            <b-card-group deck>
                <b-card bg-variant="default"
                        :header="__('messages.balance.total amount')"
                        align="center">
                    <b-card-text>
                        {{ amount }}
                    </b-card-text>
                </b-card>

                <b-card bg-variant="default"
                        :header="__('messages.balance.available amount')"
                        align="center">
                    <b-card-text>
                        {{ available }}
                    </b-card-text>
                </b-card>

                <b-card bg-variant="default" text-variant="dark"
                        :header="__('messages.balance.locked amount')"
                        align="center">
                    <b-card-text>
                        {{ locked }}
                    </b-card-text>
                </b-card>
            </b-card-group>
        </b-card-body>
        <b-card-footer align="center">
            <b-button variant="secondary">
                {{ __("messages.withdraw funds") }}
            </b-button>
        </b-card-footer>
    </b-card>
</template>
<script src="./balance.js"></script>