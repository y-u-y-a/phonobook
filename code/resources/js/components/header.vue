<template>
    <header>
        <div class="wrapper">
            <div class="title">
                <router-link to="/">phonoBook</router-link>
            </div>
            <nav>
                <ul>
                    <li v-if="!is_admin" @click="switch_admin"><router-link to="/">管理トップへ</router-link></li>
                    <li v-else-if="is_admin" @click="switch_admin"><router-link to="/">ユーザートップへ</router-link></li>
                </ul>
            </nav>
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
    header {
        background-color: $black;
        .wrapper {
            position: relative;
            width: 90%;
            margin: 0 auto;
            padding: 1.5rem 0;
            .title {
                display: inline-block;
                font-size: 36px;
                font-weight: bold;
                letter-spacing: 5px;

            }
            nav {
                display: inline-block;
                position: absolute;
                right: 0;
                line-height: 36px;
                ul{
                    font-size: 0;
                }
                li{
                    display: inline-block;
                    margin-left: 20px;
                }
                a {
                    display: inline-block;
                    padding: 0 20px;
                    font-size: 18px;
                    border: 1px solid white;
                    border-radius: 25px;
                }
                a:hover {
                    color: $black;
                    background: $white;
                }
            }
        }
    }
}
.title, a {
    color: $white;
}
</style>
