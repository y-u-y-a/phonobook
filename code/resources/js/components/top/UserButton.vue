<template>
    <li>
        <a :href=path >{{ button_name }}</a>
    </li>
</template>


<script>
export default {
    props: ["button_name", "path"]
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

li {
    margin-bottom: 30px;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    border: 1px solid $link-blue;
    border-radius: 4px;
    a{
        display: block;
        padding: 25px;
        color: $link-blue;
    }
    a:hover {
        color: $white;
        background: $link-blue;
        opacity: 0.7;
    }
}
</style>
