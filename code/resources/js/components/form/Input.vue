<template>
    <div class="form-input">
        <label>{{ label }}：</label>
        <!-- inputされる度に親側の@inputを発火(v-modelのデフォルトイベント) -->
        <input @input="issueEvent" :value="value" :placeholder=placeholder type="text" required />
    </div>
</template>


<script>

export default {

    props: ["label", "placeholder", "value"],

    methods: {
        // 親へのイベントを発行し、データ譲渡
        issueEvent(e){
            this.$emit("input", e.target.value)
        }
    }
}
</script>


<style lang="scss" scoped>
.form-input {
    display: inline-block;
    margin-bottom: 2rem;
    label {
        font-size: 18px;
    }
    input {
        font-size: 18px;
    }
}
</style>
