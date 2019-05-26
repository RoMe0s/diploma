<template>
    <b-form-row>
        <b-col>
            <b-form-group>
                <b-form-input v-model="value.value"
                              v-validate="'required|max:255'"
                              :placeholder="__('messages.value')"
                              :data-vv-name="validationName('value')"
                              :data-vv-as="__('messages.value')"
                              :state="noErrors(validationName('value'))"/>
                <b-form-invalid-feedback>
                    {{ errors.first(validationName("value")) }}
                </b-form-invalid-feedback>
            </b-form-group>
        </b-col>
        <b-col>
            <b-form-row>
                <b-col md="6">
                    <b-form-group>
                        <b-form-select v-model="value.type"
                                       :options="types"
                                       v-validate="'required'"
                                       :data-vv-name="validationName('type')"
                                       :data-vv-as="__('fields.type')"
                                       :state="noErrors(validationName('type'))">
                            <template slot="first">
                                <option :value="null" disabled>
                                    -- {{ __("messages.please select an option") }} --
                                </option>
                            </template>
                        </b-form-select>
                        <b-form-invalid-feedback>
                            {{ errors.first(validationName("type")) }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col md="5">
                    <b-form-group>
                        <b-form-input min="0"
                                      type="number"
                                      v-model="value.count"
                                      :placeholder="__('fields.count')"
                                      v-validate="'required|integer|min_value:1|max:11'"
                                      :data-vv-name="validationName('count')"
                                      :data-vv-as="__('fields.count')"
                                      :state="noErrors(validationName('count'))"/>
                        <b-form-invalid-feedback>
                            {{ errors.first(validationName("count")) }}
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
<script src="./keys.js"></script>
