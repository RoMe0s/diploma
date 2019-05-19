<template>
    <b-form-row>
        <b-col>
            <b-form-group>
                <b-form-select name="type" v-model="value.type" :options="blocks" v-validate="'required'"
                               :state="noErrors('type')">
                    <template slot="first">
                        <option :value="null" disabled>-- {{ __("messages.please select an option") }} --</option>
                    </template>
                </b-form-select>
                <b-form-invalid-feedback>
                    {{ errors.first("type") }}
                </b-form-invalid-feedback>
            </b-form-group>
        </b-col>
        <b-col>
            <b-form-row>
                <b-col md="6">
                    <b-form-group>
                        <b-form-input name="min" type="number" min="0"
                                      v-model="value.qty.min"
                                      :placeholder="__('messages.qty.min')"
                                      v-validate="'required|numeric|min_value:0|max:11'"
                                      :state="noErrors('min')"/>
                        <b-form-invalid-feedback>
                            {{ errors.first("min") }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col md="5">
                    <b-form-group>
                        <b-form-input name="max" type="number" min="0"
                                      v-model="value.qty.max"
                                      :placeholder="__('messages.qty.max')"
                                      v-validate="'required|numeric|min_value:0|max:11'"
                                      :state="noErrors('max')"/>
                        <b-form-invalid-feedback>
                            {{ errors.first("max") }}
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