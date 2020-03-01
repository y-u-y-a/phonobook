<template>
    <div>
        <div id="camera">
            <!-- カメラによる動画の挿入 -->
            <video autoplay ref="video" width="300" height="200"></video>
            <!-- 切り取った画像を表示 -->
            <canvas ref="canvas" width="300" height="200"></canvas>
        </div>
        <FormButton @signalEvent="takeFace" button_name="撮影する"></FormButton>
        <FormButton @signalEvent="authFace" button_name="認証する"></FormButton>
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
            face_image: null,
            user: null
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

            var camera_config = {
                audio: false,
                video: {
                    width: 300,
                    height: 200,
                    facingMode: "user" // フロントカメラ
                    // facingMode: { exact: "environment" } // リアカメラ
                }
            }
            // カメラの起動
            navigator.mediaDevices.getUserMedia(camera_config)
            .then((stream) => {
                this.video.srcObject = stream
                this.video.onloadedmetadata = e => {
                    this.video.play()
                }
            })
            .catch((error) => {
                console.log(error.name + ": " + error.message)
            })
        },

        // face_image取得・canvas描画
        takeFace() {
            // 動画から2Dを取得(drawImage()を使えるようにする)
            var ctx = this.canvas.getContext("2d")

            ctx.drawImage(
                this.video,
                0,
                0,
                this.canvas.width,
                this.canvas.height
            )
            var type = "image/jpeg"
            // base64として取得
            var base64 = this.canvas.toDataURL(type)
            // // base64の接頭部分を削除して設置
            this.face_image = base64.replace(/^.*,/, "")
        },

        // VRと通信で本人データの取得・stateの変更
        authFace() {
            var params = {
                face_image: this.face_image
            }

            // 本人データの取得
            axios.post("/api/users/authFace", params)
            .then((response) => {

                this.user = response.data

                // 親のイベント発火(login/arrival/borrow)
                if(this.user){
                    this.$emit("signalEvent", this.user)
                }
                else{
                    alert("社員データが存在しません")
                }
            })
            .catch((error) => {
                alert("顔の撮影が必要です")
                console.log(error.name + ": " + error.message)
            })
        }


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
