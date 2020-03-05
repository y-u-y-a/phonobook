<template>
    <div>
        <div class="half-box">
            <!-- 顔 -->
            <Camera @signalEvent="getAuthUser" />
            <!-- バーコード -->
            <LiveCamera @signalEvent="getBookWithOpenBD" />
        </div>

        <div class="half-box">
            <div id="auth-result">
                <div class="borrower">
                    <span v-if="!auth_user" class="disable">貸出し不可：カメラ撮影が必要です</span>
                    <span v-else-if="auth_user" class="able">貸出し可能：{{auth_user.name}}</span>
                </div>
                <div class="book-image">
                    <img v-if="book.title" :src="book.cover" :alt="book.title" class="able" />
                    <img v-else-if="!book.title" :src="book.cover" alt="No Image" class="disable" />
                </div>
                <FormButton  button_name="この本を借りる" class="button"
                    @signalEvent="borrowBook({
                        isbn: book.isbn,
                        auth_user: auth_user,
                        dest: '/book/Borrow'
                    })"
                />
            </div>
        </div>
    </div>
</template>

<script>

import Camera from "../../components/Camera.vue"
import LiveCamera from "../../components/LiveCamera.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        Camera,
        LiveCamera,
        FormButton
    },

    data() {
        return {
            book: {
                isbn: "",
                title: "",
                cover: "/no_image.png"
            },
            auth_user: null
        }
    },

    methods: {

        ...mapActions("Book", ["borrowBook"]),

        getBookWithOpenBD(isbn) {

            if (isbn == "") {
                alert("ISBNを入力してください。")
                return
            }
            if (isbn.length != 13) {
                alert("ISBNは13桁で入力してください。")
                return
            }

            // アクセス開始
            const url = "https://api.openbd.jp/v1/get?isbn=" + isbn

            $.getJSON(url, (reply) => {

                if (reply[0] == null){
                    return
                }

                // 本データの取得
                const book = reply[0].summary

                this.book.isbn = isbn
                this.book.title = book.title

                // 存在すれば取得
                if (book.cover != "") {
                    this.book.cover = book.cover
                }

                console.log("取得した本データ", book)
            })
        },

        getAuthUser(user){
            this.auth_user = user
            console.log("認証ユーザー", this.auth_user)
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

#auth-result{
    width: 90%;
    margin: 2rem auto 0;
    padding: 2rem 0;
    background: $white;
    .borrower{
        padding-bottom: 1rem;
        text-align: center;
        .disable {
            color: $red;
            font-weight: bold;
            font-size: 16px;
        }
        .able {
            color: $green;
            font-weight: bold;
            font-size: 16px;
        }
    }
    .book-image{
        padding-bottom: 2rem;
        img {
            display: block;
            height: 375px;
            width: 280px;
            margin: 0 auto;
        }
        .disable {
            border: 5px solid $red;
        }
        .able {
            border: 5px solid $green;
        }
    }
}
</style>

