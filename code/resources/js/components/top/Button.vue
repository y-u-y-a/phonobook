<template>
    <router-link
        tag="button"
        :to="`${path}`"
        class="d-block px-0 py-2 b-font-24 radius-4 bg-white shadow dot">
        {{ button_name }}
    </router-link>
</template>


<script>
export default {
    props: ["button_name", "path"]
}
</script>
