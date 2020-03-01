<template>
    <div>
        <div class="half-box">
            <Camera @signalEvent="changeState"></Camera>
            <!-- 仮置き -->
            <FormButton @signalEvent="searchBookWithISBN" button_name="本を取得する"></FormButton>
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
                    <img v-if="book.title" class="able" :src="image" alt="No Image" />
                </div>
                <FormButton @signalEvent="borrowBook" button_name="この本を借りる" class="button"></FormButton>
            </div>
        </div>
    </div>
</template>

<script>

import Camera    from "../../components/Camera.vue"
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

        // ISBNから本データを取得する
        searchBookWithISBN() {
            // openBDに送信するデータを定義
            const isbn = this.isbn
            const url = "https://api.openbd.jp/v1/get?isbn=" + isbn

            var vm = this

            if (isbn == "") {
                alert("ISBNを入力してください")
            } else if (isbn.length != 13) {
                alert("ISBNは13桁で入力してください")
            } else {
                // アクセス開始
                $.getJSON(url, function(data) {
                    // dataは,APIからの返り値
                    if (data[0] != null) {
                        // data配列に取得
                        vm.book = data[0].summary
                        // 画像の表示のみ(image)
                        if (vm.book.cover != "") {
                            vm.image = vm.book.cover
                        }
                    } else {
                        alert("データが見つかりません")
                    }
                })
            }
        },

        changeState(user){
            console.log(user)
            this.auth_user = user
        },

        // 貸出処理(顔認証)
        borrowBook() {
        //     var path = "/api/books/" + this.isbn + "/borrow/" + this.auth_user.id
        //     axios.get(path)
        //     .then((response) => {
        //         // 返却日の取得
        //         var today = new Date()
        //         today.setDate(today.getDate() + 14)
        //         var returnDate = today.toLocaleDateString()
        //         // アラートで表示
        //         alert(`${response.data}\n返却日は${returnDate}です。`)
        //         location.href = "/"
        //     })
        //     .catch((error) => {
        //         alert("本データを取得してください")
        //         console.log(error.name + ": " + error.message)
        //     })
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

