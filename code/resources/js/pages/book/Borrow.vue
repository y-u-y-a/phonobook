<template>
    <div class="row">
        <div class="col-6 mt-2">
            <!-- 顔 -->
            <Camera
                camera_type="capture"
                @signalEvent="getAuthUser" />
            <!-- バーコード -->
            <CodeReader @signalEvent="getBookFromOpenBD" />
        </div>

        <div class="col-6 mt-2">
            <div class="wm-90 py-2 bg-white text-center">
                <div class="borrower pb-1 b-font">
                    <span v-if="!auth_user" class="disable">貸出し不可：カメラ撮影が必要です</span>
                    <span v-else-if="auth_user" class="able">貸出し可能：{{auth_user.name}}</span>
                </div>
                <div class="book-image pb-2 b-font-16">
                    <img
                        v-if="book.title"
                        :src="book.cover"
                        :alt="book.title"
                        class="able" />
                    <img
                        v-else-if="!book.title"
                        :src="book.cover"
                        alt="No Image"
                        class="disable" />
                </div>
                <FormButton
                    button_name="この本を借りる"
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
import CodeReader from "../../components/CodeReader.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        Camera,
        CodeReader,
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

        getBookFromOpenBD(isbn) {

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
            console.log("認証ユーザー：", this.auth_user)
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

.disable {
    color: $red;
}
.able {
    color: $green;
}
.book-image{
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
</style>

