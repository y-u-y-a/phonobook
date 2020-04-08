<template>
    <button
        @click="issueTrigger"
        type="submit"
        class="rich-button"
    >{{ button_name }}</button>
</template>


<script>

export default {

    props: ["button_name"],

    methods: {
        issueTrigger(){
            this.$emit("trigger")
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

.rich-button {
    width: 150px;
    // margin: 0 auto;
    padding: 1rem 0;
    color: $white;
    font-size: 18px;
    text-decoration: none;
    border-radius: 25px;
    background-image: linear-gradient(#6795fd 0%, #67ceff 100%);
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.29);
    border-bottom: solid 4px #5e7fca;
    cursor: pointer;
}
.rich-button:hover {
    opacity: 0.7;
}
.rich-button:active {
    -webkit-transform: translateY(4px);
    transform: translateY(4px);
    box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.2);
    border-bottom: none;
}
</style>
