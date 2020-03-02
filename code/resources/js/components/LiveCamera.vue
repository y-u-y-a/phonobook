<template>
    <div id="live-camera"></div>
</template>


<script>

import Quagga from "quagga"

export default {

    mounted() {
        this.setLiveCamera()
    },

    methods: {

        setLiveCamera(){

            const config = {

                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    // カメラ映像を表示する要素を指定
                    target: document.querySelector("#live-camera"),
                    // フロントはuser
                    constraints: { facingMode: "environment" },
                },
                // 解析するワーカ数の設定
                numOfWorkers: 2,
                // バーコードの種類
                decoder: {
                    readers: ["ean_reader"]
                }
            }

            // 正常に検出されたらコールする処理
            Quagga.onDetected((success) => {

                const isbn = success.codeResult.code
                this.$emit("signalEvent", isbn)
                return
            })

            // 初期設定 -> 起動 ========================
            Quagga.init(config,
                // エラーがなければ起動(エンドレス？)
                (error) => {
                    if(!error){
                        console.log("Quagga, START!")
                        Quagga.start()
                    }
                }
            )
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../sass/app.scss";

#live-camera {
    height: 100%;
    width: 100%;
    margin: 4rem 0 0;
    overflow: hidden;
}
</style>
