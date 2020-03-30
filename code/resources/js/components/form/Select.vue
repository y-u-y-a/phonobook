<template>
    <select @change="issueEvent" class="font-18">
        <option
            v-for="option in options"
            :key="option.name"
            :value="option.value"
            :selected="option.name == default_value"
        >{{ option.name }}</option>
    </select>
</template>


<script>

export default {

    props: {
        // 中身は統一：[{name: "表示名", value: "値"}, {...}]
        options: {
            type: Array,
            required: true
        },

        default_value: {
            type: String,
            required: false
        }
    },

    methods: {
        issueEvent(e){
            this.$emit("input", e.target.value)
        }
    }
}
</script>


<style lang="scss" scoped>
</style>
