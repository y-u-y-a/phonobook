<template>
    <div class="form-textarea">
        <label>{{ label }}：</label>
        <textarea @input="issueEvent" v-model="value" :placeholder=placeholder />
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
