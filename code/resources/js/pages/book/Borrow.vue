<template>
    <div>
        <div class="flex-column mt-3 py-2 bg-white text-center">
            <!-- borrower -->
            <div class="flex-x-center b-font">
                <span v-if="!auth_user" class="disable">
                    貸出し不可：カメラ撮影が必要です
                </span>
                <span v-else-if="auth_user" class="able">
                    貸出し可能：{{auth_user.name}}
                </span>
            </div>
            <!-- book-image -->
            <div class="book-image mt-1 mb-2 b-font-16">
                <img
                    v-if="book.title"
                    :src="book.cover"
                    :alt="book.title"
                    class="able shadow" />
                <img
                    v-else-if="!book.title"
                    :src="book.cover"
                    alt="No Image"
                    class="disable shadow" />
            </div>
            <div class="flex-x-center">
                <FormRichButton
                    @trigger="modal_camera=true"
                    button_name="カメラ起動" />
                <CodeReader @trigger="getBookFromOpenBD" />
                <FormRichButton
                    button_name="この本を借りる"
                    @trigger="borrowBook({
                        isbn: book.isbn,
                        auth_user: auth_user,
                        dest: '/book/Borrow'
                    })" />
            </div>
        </div>

        <ModalCamera
            v-if="modal_camera"
            @trigger="modal_camera=false"
            @authTrigger="getBorrower"
            camera_type="capture">
            <div slot="operate-message" class="mt-4 c-white b-font-28">
                本の読み取りにはバーコードをかざしてください。
            </div>
        </ModalCamera>
    </div>
</template>

<script>

import ModalCamera from "../../modal/Camera.vue"
import CodeReader from "../../components/CodeReader.vue"
import FormRichButton from "../../components/form/RichButton.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        ModalCamera,
        CodeReader,
        FormRichButton
    },

    data() {
        return {
            book: {
                isbn: "",
                title: "",
                cover: "/no_image.png"
            },
            auth_user: null,
            modal_camera: false
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

                console.log("取得した本データ：", book)

                this.modal_camera = false
            })
        },

        getBorrower(user){

            this.auth_user = user
            this.modal_camera = false

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

