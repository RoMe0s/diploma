<template>
    <div>
        <block-component :value="value.openingBlock" v-if="value.openingBlock" class="mb-3"></block-component>
        <block-component v-for="(block, index) in value.blocks" :value="block" :key="`block-${index}`"
                         :class="`hml-${block.heading}`" class="mb-3"/>
    </div>
</template>
<script src="./plan.js"></script>
<style scoped lang="scss">
    .hml-3 {
        margin-left: 20px;
    }

    .hml-4 {
        margin-left: 40px;
    }

    .hml-5 {
        margin-left: 60px;
    }

    .hml-6 {
        margin-left: 80px;
    }
</style>