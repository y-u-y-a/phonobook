<template>
  <!-- 本のバーコード読み取り用カメラ -->
  <div id="code-reader" class="d-none"></div>
</template>


<script>
import Quagga from "quagga";

export default {
  mounted() {
    this.setCodeReaderCamera();
  },

  methods: {
    setCodeReaderCamera() {
      const config = {
        inputStream: {
          name: "Live",
          type: "LiveStream",
          // videoとcanvasを表示する要素を指定
          target: document.querySelector("#code-reader"),
          // フロントはuser
          constraints: { facingMode: "environment" }
        },
        // 解析するワーカ数の設定
        numOfWorkers: 2,
        // バーコードの種類
        decoder: {
          readers: ["ean_reader"]
        }
      };

      // 正常に検出されたらコールする処理
      Quagga.onDetected(success => {
        const isbn_code = success.codeResult.code;
        this.$emit("trigger", isbn_code);
        return;
      });

      // 初期設定 -> 起動 ========================
      Quagga.init(
        config,
        // エラーがなければ起動(エンドレス？)
        error => {
          if (!error) {
            console.log("Quagga, START!");
            Quagga.start();
          }
        }
      );
    }
  }
};
</script>
