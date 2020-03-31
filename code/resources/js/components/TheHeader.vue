<template>
    <header class="bg-black">
        <div class="wm-90 flex-x-between flex-y-center py-2">
            <RouterLink
                to="/"
                tag="h1"
                class="b-font-32 c-white pointer">phonoBook</RouterLink>
            <ul class="font-18">
                <li v-if="!is_admin" @click="switch_admin">
                    <RouterLink
                        to="/"
                        class="nav-link px-2 py-05">管理トップへ</RouterLink>
                </li>
                <li v-else-if="is_admin" @click="switch_admin">
                    <RouterLink
                        to="/"
                        class="nav-link px-2 py-05">ユーザートップへ</RouterLink>
                </li>
            </ul>
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

    h1{
        letter-spacing: 5px;
    }
    .nav-link {
        border: 1px solid white;
        border-radius: 25px;
    }
    .nav-link:hover{
        color: $black;
        background: $white;
    }
}
a,
a:hover,
h1:hover {
    color: $white;
}
</style>
