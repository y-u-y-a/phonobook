<template>
    <div class="form-input">
        <label>{{ label }}：</label>
        <!-- inputされる度に親側のsignalEventを発火させ、親で定義した関数を実行する -->
        <input @input="issueEvent" v-model="value" type="text" :placeholder=placeholder required />
    </div>
</template>


<script>

export default {

    props: ["label", "placeholder", "value"],

    methods: {
        // 親へのイベントを発行し、データ譲渡
        issueEvent(){
            this.$emit("signalEvent", this.value)
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
