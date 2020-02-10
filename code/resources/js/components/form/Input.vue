<template>
    <div class="form-input">
        <label>{{ label }}：</label>
        <!-- 親に対するイベントを発行する関数を実行 -->
        <input @input="issue" v-model="value" type="text" :placeholder=placeholder required />
    </div>
</template>


<script>
export default {
    data(){
        return {
            value: null
        }
    },

    props: ["label", "placeholder"],

    methods: {
        // 親へのイベントを発行し、データ譲渡
        issue(){
            this.$emit("onInput", this.value)
        }
    }
}
</script>


<style lang="scss" scoped>
.form-input {
    margin-bottom: 2rem;
    label {
        font-size: 18px;
    }
    input {
        font-size: 14px;
    }
}
</style>
