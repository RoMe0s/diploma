<template>
    <b-card :header="__('messages.plan')" no-body v-if="planConfig">
        <b-card-body>
            <b-form-row class="mb-3">
                <b-col align="center">
                    <b-form-checkbox @change="toggleUseOpeningBlock()" button
                                     :button-variant="useOpeningBlock ? 'success' : 'secondary'">
                        {{ __("messages.first paragraph") }}
                    </b-form-checkbox>
                    <b-form-checkbox @change="toggleUseClosingBlock" button
                                     :button-variant="useClosingBlock ? 'success' : 'secondary'">
                        {{ __("messages.last paragraph") }}
                    </b-form-checkbox>
                </b-col>
            </b-form-row>
            <b-form-row>
                <b-col>
                    <b-form-group>
                        <b-form-input type="number" min="0" v-model.number="value.sizes.from"
                                      v-validate="'required|integer|max:11|min_value:0'"
                                      :placeholder="__('messages.sizes.from')"
                                      :data-vv-as="__('messages.sizes.from')"
                                      data-vv-name="plan.sizes.from"
                                      :state="noErrors('plan.sizes.from')"/>
                        <b-form-invalid-feedback>
                            {{ errors.first("plan.sizes.from") }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group>
                        <b-form-input type="number" min="0" v-model.number="value.sizes.to"
                                      v-validate="'required|integer|max:11|min_value:0'"
                                      :placeholder="__('messages.sizes.to')"
                                      :data-vv-as="__('messages.sizes.to')"
                                      data-vv-name="plan.sizes.to"
                                      :state="noErrors('plan.sizes.to')"/>
                        <b-form-invalid-feedback>
                            {{ errors.first("plan.sizes.to") }}
                        </b-form-invalid-feedback>
                    </b-form-group>
                </b-col>
            </b-form-row>
            <block-component v-model="value.openingBlock" :plan-config="planConfig"
                             :position="planConfig.headings.opening"
                             @add-settings-block="addSettingsBlock(null, value.openingBlock)"
                             @add-keys-block="addKeysBlock(null, value.openingBlock)" v-if="useOpeningBlock"/>
            <block-component v-for="(block, index) in value.blocks" v-model="value.blocks[index]"
                             :key="`block-${blockUid(block)}`" :plan-config="planConfig" :position="index"
                             :previous-heading-type="previousHeadingType(index)" :next-same-index="nextSameIndex(index)"
                             :previous-same-index="previousSameIndex(index)" :blocks-length="blocksLength"
                             @move-up="moveUp" @move-down="moveDown" @add-before="addBefore"
                             @add-after="addAfter" @add-settings-block="addSettingsBlock"
                             @add-keys-block="addKeysBlock" @add-child="addChild" @delete="deleteBlock" ref="blocks"/>
            <block-component v-model="value.closingBlock" :plan-config="planConfig"
                             :position="planConfig.headings.closing"
                             @add-settings-block="addSettingsBlock(null, value.closingBlock)"
                             @add-keys-block="addKeysBlock(null, value.closingBlock)"
                             v-if="useClosingBlock"/>
        </b-card-body>
    </b-card>
</template>
<script src="./plan.js"></script>