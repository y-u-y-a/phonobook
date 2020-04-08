<template>
    <div class="form-group">
        <label class="mb-05">{{ label }}</label>
        <div class="flex-left">
            <!-- inputされる度に親側の@inputを発火(v-modelのデフォルトイベント) -->
            <input
                @input="issueTrigger"
                :value="value"
                :placeholder=placeholder
                type="text"
                class="form-control"
                required />
            <!-- セレクトボックス(email接尾辞用) -->
            <slot name="form-select"></slot>
        </div>
    </div>
</template>


<script>

export default {

    props: ["label", "placeholder", "value"],

    methods: {
        issueTrigger(e){
            // 親側ではv-modelでOK(=@input+:value)
            this.$emit("input", e.target.value)
        }
    }
}
</script>
