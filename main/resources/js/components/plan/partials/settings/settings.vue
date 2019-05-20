<template>
    <b-form-row>
        <b-col>
            <b-form-group>
                <b-form-select v-model="value.type"
                               :options="blocks"
                               v-validate="'required'"
                               :data-vv-name="validationName('type')"
                               :data-vv-as="__('fields.type')"
                               :state="noErrors(validationName('type'))">
                    <template slot="first">
                        <option :value="null" disabled>-- {{ __("messages.please select an option") }} --</option>
                    </template>
                </b-form-select>
                <b-form-invalid-feedback>
                    {{ errors.first(validationName("type")) }}
                </b-form-invalid-feedback>
            </b-form-group>
        </b-col>
        <b-col>
            <b-form-row>
                <b-col md="6">
                    <b-form-group>
                        <b-form-input min="0"
                                      type="number"
                                      v-model="value.min"
                                      :placeholder="__('fields.min')"
                                      v-validate="'required|integer|min_value:0|max:11'"
                                      :data-vv-name="validationName('min')"
                                      :data-vv-as="__('fields.min')"
                                      :state="noErrors(validationName('min'))"/>
                        <b-form-invalid-feedback>
                            {{ errors.first(validationName("min")) }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col md="5">
                    <b-form-group>
                        <b-form-input min="0"
                                      type="number"
                                      v-model="value.max"
                                      :placeholder="__('fields.max')"
                                      v-validate="'required|integer|max:11|min_value:' + value.min"
                                      :data-vv-name="validationName('max')"
                                      :data-vv-as="__('fields.max')"
                                      :state="noErrors(validationName('max'))"/>
                        <b-form-invalid-feedback>
                            {{ errors.first(validationName("max")) }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col md="1">
                    <b-button variant="outline-danger" @click="deleteRecord()">
                        <i class="fa fa-trash"></i>
                    </b-button>
                </b-col>
            </b-form-row>
        </b-col>
    </b-form-row>
</template>
<script src="./settings.js"></script>
