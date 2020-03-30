<template>
    <div class="container-fluid mb-2 font-18">
        <label class="row mb-05">{{ label }}</label>
        <div class="row flex-between">
            <!-- inputされる度に親側の@inputを発火(v-modelのデフォルトイベント) -->
            <input
                @input="issueEvent"
                :value="value"
                :placeholder=placeholder
                type="text"
                class="col-7"
                required />
            <!-- セレクトボックス(email接尾辞) -->
            <slot name="form-select"></slot>
        </div>
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
</style>
