<template>
    <b-form-row>
        <b-col>
            <b-form-group>
                <b-form-input name="name" v-model="value.name" v-validate="'required|max:255'"
                              :placeholder="__('messages.name')" :state="noErrors('name')"/>
                <b-form-invalid-feedback>
                    {{ errors.first("name") }}
                </b-form-invalid-feedback>
            </b-form-group>
        </b-col>
        <b-col>
            <b-form-row>
                <b-col md="6">
                    <b-form-group>
                        <b-form-select name="type" v-model="value.type" :options="types" v-validate="'required'"
                                       :state="noErrors('type')">
                            <template slot="first">
                                <option :value="null" disabled>-- {{ __("messages.please select an option") }} --
                                </option>
                            </template>
                        </b-form-select>
                        <b-form-invalid-feedback>
                            {{ errors.first("type") }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col md="5">
                    <b-form-group>
                        <b-form-input name="count" type="number" min="0" v-model="value.count"
                                      :placeholder="__('messages.count')"
                                      v-validate="'required|integer|min_value:0|max:11'" :state="noErrors('count')"/>
                        <b-form-invalid-feedback>
                            {{ errors.first("count") }}
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