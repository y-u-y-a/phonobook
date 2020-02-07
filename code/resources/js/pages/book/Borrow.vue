<template>
    <div>
        <div class="half-box">
            <Camera></Camera>
            <FormButton @click="takeFaceImage" button_name="撮影する"></FormButton>
            <FormButton @click="authWithFaceImage" button_name="認証する"></FormButton>
            <FormButton @click="searchBookWithISBN" button_name="本を取得する"></FormButton>
            <div class="inputISBN">
                <input v-model="isbn" type="text" />
            </div>
        </div>

        <div class="half-box">
            <div id="auth-result">
                <div class="borrower">
                    <span v-if="user.name == null" class="disable">貸出し不可：カメラ撮影が必要です</span>
                    <span v-if="user.name != null" class="able">貸出し可能：{{user.name}}</span>
                </div>
                <div class="book-image">
                    <img v-if="book.title == null" class="disable" :src="image" alt="No Image" />
                    <img v-if="book.title != null" class="able" :src="image" alt="No Image" />
                </div>
                <FormButton @click="borrowBook" button_name="この本を借りる" class="button"></FormButton>
            </div>
        </div>
    </div>
</template>

<script>

import Camera    from "../../components/Camera.vue"
import FormButton from "../../components/form/Button.vue"

export default {
    components: {
        Camera,
        FormButton
    },

    data() {
        return {
            video: {},
            canvas: {},
            faceImage: "",
            isbn: "9784798038094",
            image: "/no_image.png",
            book: {},
            user: {}
        };
    },

    mounted() {
        this.setUpCamera();
    },

    methods: {
        // カメラの起動
        setUpCamera() {
            //HTML要素から取得→dataに代入
            this.video = this.$refs.video;
            this.canvas = this.$refs.canvas;
            //カメラ設定
            var constraints = {
                audio: false,
                video: {
                    width: 300,
                    height: 200,
                    facingMode: "user" // フロントカメラを利用する
                    // facingMode: { exact: "environment" }    // リアカメラを利用する場合
                }
            };
            // カメラの起動(JSでの撮影許可を求める)
            navigator.mediaDevices
                .getUserMedia(constraints)
                // 成功した場合
                .then(stream => {
                    this.video.srcObject = stream;
                    this.video.onloadedmetadata = e => {
                        this.video.play();
                    };
                })
                // 失敗した場合
                .catch(error => {
                    console.log(error.name + ": " + error.message);
                });
        },


        // 撮影してデータを取得
        takeFaceImage() {
            // 動画から画像の切り取り(2Dで)
            var ctx = this.canvas.getContext("2d");
            // カメラ→画像に変換
            ctx.drawImage(
                this.video, // 描画されるイメージ
                0, // dx
                0, // dy
                this.canvas.width, // dw(解像度)
                this.canvas.height // dh(解像度)
            );

            // 撮影した画像の処理 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓
            var type = "image/jpeg";
            // base64に変換して取得する
            var base64 = this.canvas.toDataURL(type);
            // // base64の接頭部分を削除して設置
            this.faceImage = base64.replace(/^.*,/, "");
        },


        // VRで本人データの取得・stateの変更
        authWithFaceImage() {
            var params = {
                faceImage: this.faceImage
            };
            var axios = require("axios");
            axios.post("/api/users/authFace", params)
                .then(response => {
                    this.user = response.data;
                    // nullだった場合
                    if (!this.user) {
                        alert("社員データが存在しません");
                    }
                })
                .catch(error => {
                    alert("顔の撮影が必要です");
                    console.log(error.name + ": " + error.message);
                });
        },


        // // 画像からISBNを取得する(searchBookWithISBN()内で使う関数)
        // bostBookBarcodeImage(){
        //     var params = {
        //         captureImage: this.faceImage
        //     };
        //     var axios = require("axios");
        //     axios.post("/api/books/barcode", params)
        //     .then((response)=>{
        //         console.log(response.data);
        //     })
        //     .catch((error)=>{
        //         console.log(error.name + ": " + error.message);
        //     })
        // },


        // ISBNから本データを取得する
        searchBookWithISBN() {
            // openBDに送信するデータを定義
            const isbn = this.isbn;
            const url = "https://api.openbd.jp/v1/get?isbn=" + isbn;
            // 関数内ではthisが他を指すことがあるので、予め変数に代入しておく
            var vm = this;

            if (isbn == "") {
                alert("ISBNを入力してください");
            } else if (isbn.length != 13) {
                alert("ISBNは13桁で入力してください");
            } else {
                // アクセス開始
                $.getJSON(url, function(data) {
                    // dataは,APIからの返り値
                    if (data[0] != null) {
                        // data配列に取得
                        vm.book = data[0].summary;
                        // 画像の表示のみ(image)
                        if (vm.book.cover != "") {
                            vm.image = vm.book.cover;
                        }
                    } else {
                        alert("データが見つかりません");
                    }
                });
            }
        },


        // 貸出処理(顔認証)
        borrowBook() {
            var path = "/api/books/" + this.isbn + "/borrow/" + this.user.id;
            var axios = require("axios");
            axios.get(path)
                .then(response => {
                    // 返却日の取得
                    var today = new Date();
                    today.setDate(today.getDate() + 14);
                    var returnDate = today.toLocaleDateString();
                    // アラートで表示
                    alert(`${response.data}\n返却日は${returnDate}です。`);
                    location.href = "/user/top";
                })
                .catch(error => {
                    alert("本データを取得してください");
                    console.log(error.name + ": " + error.message);
                });
        }
    }
};
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

