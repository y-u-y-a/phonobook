<template>
    <header class="bg-black c-white">
        <div class="row wm-90 flex-justify-between flex-y-center py-2">
            <RouterLink
                tag="h1"
                to="/"
                class="b-font-32 letter-5 pointer">
                phonoBook
            </RouterLink>
            <RouterLink
                tag="div"
                to="/"
                class="pc nav-link px-2 py-05　font-18 pointer">
                トップへ
            </RouterLink>
        </div>
    </header>
</template>


<script>

import { mapState, mapMutations } from "vuex"

export default {

    computed: {
        ...mapState("User", ["is_admin"])
    },

    methods: {
        ...mapMutations("User", ["switch_admin"])
    }
}
</script>


<style lang="scss" scoped>

@import "../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {

    .nav-link {
        border: 1px solid white;
        border-radius: 25px;
    }
    .nav-link:hover{
        color: $black;
        background: $white;
    }
}
</style>
