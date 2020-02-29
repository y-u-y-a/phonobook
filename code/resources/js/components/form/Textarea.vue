<template>
    <div class="form-textarea">
        <label>{{ label }}：</label>
        <textarea @input="issueEvent" :value="value" :placeholder=placeholder />
    </div>
</template>


<script>

export default {

    props: ["label", "placeholder", "value"],

    methods: {
        issueEvent(e){
            this.$emit("input", e.target.value)
        }
    }
}
</script>
