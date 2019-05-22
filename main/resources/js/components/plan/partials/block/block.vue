<template>
    <b-card class="mb-3" bg-variant="light" :style="{'margin-left': nesting * 20 + 'px'}">
        <b-form-row>
            <b-col>
                <b-form-row class="mb-3">
                    <b-col v-if="isMovable && previousSameIndex !== null || nextSameIndex">
                        <b-button-group>
                            <b-button variant="primary" @click="moveUp()" v-if="previousSameIndex !== null">
                                <i class="fa fa-arrow-up"></i>
                            </b-button>
                            <b-button variant="primary" @click="moveDown()" v-if="nextSameIndex">
                                <i class="fa fa-arrow-down"></i>
                            </b-button>
                        </b-button-group>
                    </b-col>
                    <b-col align="right">
                        <b-button-group>
                            <b-button variant="outline-info" v-if="hasChild" @click.prevent="addChild()">
                                <i class="fa fa-compress"></i>
                            </b-button>
                            <b-dropdown variant="outline-primary" no-caret v-if="isEditable">
                                <template slot="button-content">
                                    <i class="fa fa-plus"></i>
                                </template>
                                <b-dropdown-item @click.prevent="addBefore()" v-if="previousHeadingType">
                                    Before
                                </b-dropdown-item>
                                <b-dropdown-item @click.prevent="addAfter()">After</b-dropdown-item>
                            </b-dropdown>
                            <b-button :variant="settingsButtonVariant()" @click.prevent="toggleShowSettings()">
                                <i class="fa fa-cog"></i>
                            </b-button>
                            <b-button :variant="keysButtonVariant()" @click.prevent="toggleShowKeys()">
                                <i class="fa fa-key"></i>
                            </b-button>
                            <b-button variant="outline-danger" @click.prevent="deleteBlock()"
                                      :disabled="blocksLength < 2" v-if="isMovable">
                                <i class="fa fa-trash"></i>
                            </b-button>
                        </b-button-group>
                    </b-col>
                </b-form-row>

                <div v-show="!showSettings && !showKeys">
                    <b-form-row>
                        <b-col v-if="isMovable">
                            <b-form-group>
                                <b-form-select v-model="value.heading"
                                               :options="headingOptions"
                                               v-validate="'required'"
                                               :data-vv-as="__('fields.heading')"
                                               :data-vv-name="validationName('heading')"
                                               :state="noErrors(validationName('heading'))">
                                    <template slot="first">
                                        <option :value="null" disabled>-- {{ __("messages.please select an option") }}
                                            --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-invalid-feedback>
                                    {{ errors.first(validationName("heading")) }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </b-col>
                        <b-col v-if="isMovable">
                            <b-form-group>
                                <b-form-input v-model="value.name"
                                              v-validate="'max:255'"
                                              :data-vv-as="__('fields.name')"
                                              :data-vv-name="validationName('name')"
                                              :state="noErrors(validationName('name'))"/>
                                <b-form-invalid-feedback>
                                    {{ errors.first(validationName("name")) }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </b-col>
                        <b-col :md="isMovable ? '4' : '12'">
                            <b-form-row>
                                <b-col>
                                    <b-form-group>
                                        <b-form-input min="0"
                                                      type="number"
                                                      v-model="value.sizes.from"
                                                      v-validate="'required|integer|max:11|min_value:0'"
                                                      :data-vv-as="__('fields.sizes.from')"
                                                      :data-vv-name="validationName('sizes.from')"
                                                      :placeholder="__('messages.sizes.from')"
                                                      :state="noErrors(validationName('sizes.from'))"/>
                                        <b-form-invalid-feedback>
                                            {{ errors.first(validationName("sizes.from")) }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group>
                                        <b-form-input min="0"
                                                      type="number"
                                                      v-model="value.sizes.to"
                                                      v-validate="'required|integer|max:11|min_value:0'"
                                                      :data-vv-as="__('fields.sizes.to')"
                                                      :data-vv-name="validationName('sizes.to')"
                                                      :placeholder="__('messages.sizes.to')"
                                                      :state="noErrors(validationName('sizes.to'))"/>
                                        <b-form-invalid-feedback>
                                            {{ errors.first(validationName("sizes.to")) }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>
                                </b-col>
                            </b-form-row>
                        </b-col>
                    </b-form-row>
                    <b-form-row>
                        <b-col>
                            <b-form-group>
                                <b-form-textarea v-model="value.description"
                                                 :placeholder="__('messages.description')"
                                                 v-validate="'max:255'"
                                                 :data-vv-as="__('fields.description')"
                                                 :data-vv-name="validationName('description')"
                                                 :state="noErrors(validationName('description'))"/>
                                <b-form-invalid-feedback>
                                    {{ errors.first(validationName("description")) }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </b-col>
                    </b-form-row>
                </div>

                <b-card v-show="showSettings">
                    <b-form-row class="mb-3" v-if="isMovable">
                        <b-col align="center">
                            <b-form-checkbox v-model="value.allowBlocks" button
                                             :button-variant="value.allowBlocks ? 'success' : 'secondary'">
                                {{ __("messages." + (allowBlocks ? "disallow" : "allow")) }}
                                {{ __("messages.custom blocks") }}
                            </b-form-checkbox>
                        </b-col>
                    </b-form-row>
                    <settings-component v-for="(block, index) in value.settings" v-model="value.settings[index]"
                                        :validation-name-prefix="validationName(`settings.${index}`)"
                                        :key="'settings-' + value.uid + '-' + index" :blocks="planConfig.settings"
                                        @delete="deleteSettingsBlock(index)" ref="settings-blocks"/>
                    <b-form-row>
                        <b-col align="center">
                            <b-button variant="info" @click="addSettingsBlock()">
                                <i class="fa fa-plus"></i>
                            </b-button>
                        </b-col>
                    </b-form-row>
                </b-card>

                <b-card v-show="showKeys">
                    <keys-component v-for="(keys, index) in value.keys" v-model="value.keys[index]"
                                    :validation-name-prefix="validationName(`keys.${index}`)"
                                    :key="'keys-' + value.uid + '-' + index" :types="planConfig.keys"
                                    @delete="deleteKeysBlock(index)" ref="keys-blocks"/>
                    <b-form-row>
                        <b-col align="center">
                            <b-button variant="info" @click="addKeysBlock()">
                                <i class="fa fa-plus"></i>
                            </b-button>
                        </b-col>
                    </b-form-row>
                </b-card>
            </b-col>
        </b-form-row>
    </b-card>
</template>
<script src="./block.js"></script>
