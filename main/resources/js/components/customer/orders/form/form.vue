<template>
    <div>
        <b-form-group :label="__('fields.title')">
            <b-form-input name="name" v-model="value.name" :placeholder="__('fields.title')"
                          v-validate="'max:255'" :state="noErrors('name')"/>
            <b-form-invalid-feedback>
                {{ errors.first("name") }}
            </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group :label="__('fields.description')">
            <b-form-textarea name="description" v-model="value.description" :placeholder="__('fields.description')"
                             v-validate="'max:10000'" :state="noErrors('description')"/>
            <b-form-invalid-feedback>
                {{ errors.first("description") }}
            </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group :label="__('fields.price')">
            <b-form-input type="number" name="price" min="0.01" step="0.01" v-model="value.price"
                          :placeholder="__('fields.price')"
                          v-validate="'required|decimal:2|min_value:0.01'" :state="noErrors('price')"/>
            <b-form-invalid-feedback>
                {{ errors.first("price") }}
            </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group :label="__('fields.estimate')">
            <b-form-input type="number" name="estimate" min="1" v-model="value.estimate"
                          :placeholder="__('fields.estimate')" v-validate="'required|integer|min_value:1'"
                          :state="noErrors('estimate')"/>
            <b-form-invalid-feedback>
                {{ errors.first("estimate") }}
            </b-form-invalid-feedback>
        </b-form-group>
        <b-form-group :label="__('fields.project')">
            <b-input-group :label="__('fields.project')">
                <b-form-select name="project_id"
                               v-model="value.project_id"
                               :options="projects"
                               :state="noErrors('project_id')">
                    <template slot="first">
                        <option :value="null" disabled>
                            -- {{ __("messages.please select an option") }} --
                        </option>
                    </template>
                </b-form-select>
                <b-input-group-append>
                    <b-button variant="warning" @click="clearProjectId()">
                        {{ __("messages.clear") }}
                    </b-button>
                </b-input-group-append>
            </b-input-group>
            <b-form-invalid-feedback>
                {{ errors.first("project_id") }}
            </b-form-invalid-feedback>
        </b-form-group>
        <b-form-row class="mb-3">
            <b-col>
                <b-button block variant="outline-danger" @click="clearPlan()" :disabled="!hasBlocks">
                    {{ __("messages.clear plan") }}
                </b-button>
            </b-col>
            <b-col>
                <b-button block variant="outline-primary" @click="initPlan()" :disabled="hasBlocks">
                    {{ __("messages.init plan") }}
                </b-button>
            </b-col>
        </b-form-row>
        <plan-component v-model="value.plan"/>
    </div>
</template>
<script src="./form.js"></script>