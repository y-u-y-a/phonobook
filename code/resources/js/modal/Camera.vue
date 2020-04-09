<template>
    <div @click="issueTrigger" class="modal-default text-center">
        <!-- カメラによる動画の挿入 -->
        <video
            ref="video"
            width="100%"
            height="60%"
            class="mb-4"
            autoplay >
        </video>
        <!-- 切り取った画像を描画 -->
        <canvas ref="canvas" class="d-none"></canvas>
        <!-- 撮影と認証処理(Borrow.vue, Arrival.vueで使用) -->
        <FormRichButton
            v-if="camera_type=='capture'"
            @trigger="takeFace(); authFace()"
            button_name="顔を認証する" />

        <slot name="operate-message"></slot>
    </div>
</template>


<script>

import FormRichButton from "../components/form/RichButton.vue"

export default {

    components: {
        FormRichButton
    },

    props: ["camera_type"],

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

        issueTrigger(){
            this.$emit("trigger")
        },

        setCamera(){
            //HTML要素から取得→dataに代入
            this.video = this.$refs.video
            this.canvas = this.$refs.canvas

            var camera_config = {
                audio: false,
                video: {
                    // width: 500,
                    // height: 250,
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
        async authFace() {

            if(!this.face_image){
                return alert("撮影をしてください。")
            }

            var params = {
                face_image: this.face_image
            }

            // 本人データの取得
            await axios.post("/api/users/authFace", params)
            .then((response) => {

                this.user = response.data

                if(!this.user){
                    return alert("認証できませんでした。")
                }

                // 取得したユーザーを使った処理を親側で実行
                this.$emit("authTrigger", this.user)
            })
        }
    }
}
</script>
