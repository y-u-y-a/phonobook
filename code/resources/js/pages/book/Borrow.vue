<template>
    <div>
        <div class="half-box">
            <Camera @signalEvent="getAuthUser"></Camera>
            <!-- 仮置き -->
            <FormButton @signalEvent="getBookWithOpenBD" button_name="本を取得する"></FormButton>
            <div class="inputISBN">
                <input v-model="isbn" type="text" />
            </div>
        </div>

        <div class="half-box">
            <div id="auth-result">
                <div class="borrower">
                    <span v-if="!auth_user" class="disable">貸出し不可：カメラ撮影が必要です</span>
                    <span v-else-if="auth_user" class="able">貸出し可能：{{auth_user.name}}</span>
                </div>
                <div class="book-image">
                    <img v-if="!book.title" class="disable" :src="image" alt="No Image" />
                    <img v-else-if="book.title" class="able" :src="image" :alt="book.title" />
                </div>
                <FormButton @signalEvent="borrowBook({isbn: book.isbn, auth_user: auth_user, dest: '/book/Borrow'})" button_name="この本を借りる" class="button"></FormButton>
            </div>
        </div>
    </div>
</template>

<script>

import Camera from "../../components/Camera.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        Camera,
        FormButton
    },

    data() {
        return {
            isbn: "9784798038094",
            image: "/no_image.png",
            book: {},
            auth_user: null
        }
    },

    methods: {

        ...mapActions("Book", ["borrowBook"]),

        // ISBNでopenBDから本データを取得
        getBookWithOpenBD() {

            const isbn = this.isbn
            const url = "https://api.openbd.jp/v1/get?isbn=" + isbn

            if (isbn == "") {
                alert("ISBNを入力してください。")
                return
            }
            if (isbn.length != 13) {
                alert("ISBNは13桁で入力してください。")
                return
            }
            // アクセス開始
            $.getJSON(url, (reply_data) => {
                // reply_dataは,APIからの返り値
                if (reply_data[0] != null) {

                    this.book = reply_data[0].summary

                    // 表示用の変数imageに代入
                    if (this.book.cover != "") {
                        this.image = this.book.cover
                    }
                }
                else{
                    alert("データが見つかりません。")
                }
            })
        },

        getAuthUser(user){
            this.auth_user = user
            console.log(this.auth_user)
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

