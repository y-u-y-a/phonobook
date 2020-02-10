<template>
    <div>
        <div id="camera">
            <!-- カメラによる動画の挿入 -->
            <video autoplay ref="video" width="300" height="200"></video>
            <!-- 切り取った画像を表示 -->
            <canvas ref="canvas" width="300" height="200"></canvas>
        </div>
        <FormButton @signalEvent="takeFaceImage" button_name="撮影する"></FormButton>
        <FormButton @signalEvent="authWithFaceImage" button_name="認証する"></FormButton>
    </div>
</template>


<script>

import FormButton from "../components/form/Button.vue"

export default {
    props: [""],

    components: {
        FormButton
    },

    data() {
        return {
            video: {},
            canvas: {},
            capture: "",
        }
    },

    mounted() {
        this.setCamera()
    },

    methods: {
        setCamera(){
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

        takeFaceImage() {
            console.log("aaa")
            // 動画から2Dを取得
            var ctx = this.canvas.getContext("2d")
            // カメラ→画像に変換
            ctx.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height)
            // 画像に対する処理開始
            var type = "image/jpeg"
            // base64として取得
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
    }
}
</script>


<style lang="scss" scoped>

@import "../../sass/app.scss";

#camera {
    margin: 4rem 0;
    text-align: center;
    video,
    canvas {
        background-color: $white;
        border: 1px solid $silver;
    }
}
</style>
