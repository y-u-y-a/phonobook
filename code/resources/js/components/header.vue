<template>
    <header>
        <div class="header-wrapper">
            <div class="title">
                <router-link to="/" title="Home">phonoBook</router-link>
            </div>
            <nav>
                <ul>
                    <li><router-link to="/">管理トップへ</router-link></li>
                    <li><router-link to="/">ユーザートップへ</router-link></li>
                </ul>
                <!-- <ul>
                    <li v-if="currentURL != HOST + '/admin'">
                        <router-link :to="{name: 'admin'}">管理トップへ</router-link>
                    </li>
                    <li v-if="currentURL != HOST + '/user'">
                        <router-link :to="{name: 'user'}">ユーザートップへ</router-link>
                    </li>
                </ul> -->
            </nav>
        </div>
    </header>
</template>


<script>
export default {
    data() {
        return {
            currentURL: "",
            HOST: ""
        }
    },
    created() {
        this.currentURL = location.href
        this.HOST       = location.origin
    }
}
</script>


<style lang="scss" scoped>

@import "../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {
    header {
        background-color: $black;
        .header-wrapper {
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
