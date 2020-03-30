<template>
    <router-link
        tag="button"
        :to="`${path}`"
        class="d-block w-100 py-2 mb-3 b-font-24"
        >{{ button_name }}</router-link>
</template>


<script>
export default {
    props: ["button_name", "path"]
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

button {
    padding: 0;
    border-radius: 4px;
}

</style>
