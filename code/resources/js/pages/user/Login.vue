<template>
    <div>
        <div class="half-box">
            <Camera></Camera>
            <FormButton @click="takeFaceImage" button_name="撮影する"></FormButton>
            <FormButton @click="authWithFaceImage" button_name="認証する"></FormButton>
        </div>

        <div class="half-box">
            <div id="login">
                <form @submit.prevent="login">
                    <div class="title">ログインする</div>
                    <div class="form-container">
                        <input type="hidden" name="_token" :value="csrf" />
                        <FormInput @onInput="getEmail" label="メールアドレス" placeholder="8文字以上の半角英数字" ></FormInput>
                        <FormInput @onInput="getPass" label="パスワード" placeholder="8文字以上の半角英数字" ></FormInput>
                        <FormButton @click="login" button_name="ログインする"></FormButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<script>

import Camera    from "../../components/Camera.vue"
import FormInput from "../../components/form/Input.vue"
import FormButton from "../../components/form/Button.vue"

export default {
    components: {
        Camera,
        FormInput,
        FormButton
    },

    data() {
        return {
            video: {},
            canvas: {},
            capture: "",
            csrf: document.querySelector("meta[name='csrf-token']").getAttribute("content"),
            email: "",
            password: ""
        };
    },

    mounted() {
        //HTML要素から取得→dataに代入
        this.video = this.$refs.video
        this.canvas = this.$refs.canvas

        //カメラ設定
        var constraints = {
            audio: false,
            video: {
                width: 300,
                height: 200,
                facingMode: "user" // フロントカメラを利用する
                // facingMode: { exact: "environment" }    // リアカメラを利用する場合
            }
        }
        // カメラの起動
        navigator.mediaDevices.getUserMedia(constraints)
        .then(stream => {
            this.video.srcObject = stream
            this.video.onloadedmetadata = e => {
                this.video.play()
            }
        })
        .catch(error => {
            console.log(error.name + ": " + error.message)
        })
    },

    methods: {
        takeFaceImage() {
            // 動画から画像の切り取り(2Dで)
            var ctx = this.canvas.getContext("2d")
            // カメラ→画像に変換
            ctx.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height)

            // 撮影した画像の処理 ===========================
            var type = "image/jpeg"
            // base64として取得する
            var base64 = this.canvas.toDataURL(type)
            // // base64の接頭部分を削除して設置
            this.faceImage = base64.replace(/^.*,/, "")
        },

        // VRで本人データの取得・stateの変更
        authWithFaceImage() {
            var params = {
                faceImage: this.faceImage
            }
            axios.post("/api/users/authFace", params)
            .then(response => {
                var user = response.data
                if (!user) {
                    alert("社員データが存在しません")
                } else {
                    // 本人データの取得(arrival.vueと異なる部分)
                    this.email = user.email
                    this.password = ""
                }
            })
            .catch(error => {
                alert("顔の撮影が必要です")
                console.log(error.name + ": " + error.message)
            })
        },

        getEmail(value){
            this.email = value
        },
        getPass(value){
            this.password = value
        },

        async login() {
            var params = {
                email: this.email,
                password: this.password
            }
            await this.$store.dispatch("User/login", params)
            .then(response => {
                alert("ログインしました")
                this.$router.push("/")
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
                alert("ログインに失敗しました")
            })
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

#login{
    width: 90%;
    margin: 0 auto;
}
form{
    margin: 2rem 0;
    padding-bottom: 2rem;
    background: $white;
    .title{
        padding: 2rem 0;
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 2px;
        border-bottom: 1px solid $silver;
        text-align: center;
    }
    .form-container{
        width: 90%;
        margin: 0 auto;
        padding-top: 2rem;
    }
}
</style>
