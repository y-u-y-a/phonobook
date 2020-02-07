<template>
    <div class="form-input">
        <label>{{ label }}：</label>
        <input type="text" :placeholder=placeholder required />
    </div>
</template>


<script>
export default {
    props: ["label", "placeholder"]
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
