<template>
  <div id="bookBorrow">
    <div class="leftArea">
      <div class="capture-wrapper">
        <!-- カメラによる動画の挿入 -->
        <video autoplay ref="video" width="300" height="200"></video>
        <!-- 切り取った画像を表示 -->
        <canvas ref="canvas" width="300" height="200"></canvas>
        <ul>
          <li>
            <button @click="takeFaceImage()">撮影する</button>
          </li>
          <li>
            <button @click="authWithFaceImage()">認証する</button>
          </li>
        </ul>
      </div>
      <!-- 以下は仮置き ============= -->
      <button @click="searchBookWithISBN()">本を取得する</button>
      <div class="inputISBN">
        <input v-model="isbn" type="text" />
      </div>
      <!-- ======================== -->
    </div>
    <div class="rightArea">
      <div class="borrow-wrapper">
        <div class="getBook">
          <p class="borrower-wrapper">
            <span v-if="user.name == null" class="disable">貸出し不可：カメラ撮影が必要です</span>
            <span v-if="user.name != null" class="able">貸出し可能：{{user.name}}</span>
          </p>
          <div class="bookCover">
            <img v-if="book.title == null" class="disable" :src="image" alt="No Image" />
            <img v-if="book.title != null" class="able" :src="image" alt="No Image" />
          </div>
        </div>
        <div class="borrowButton">
          <button @click="borrowBook()">この本を借りる</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
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
          // facingMode: { exact: "environment" }  // リアカメラを利用する場合
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
    //   var params = {
    //     captureImage: this.faceImage
    //   };
    //   var axios = require("axios");
    //   axios.post("/api/books/barcode", params)
    //   .then((response)=>{
    //     console.log(response.data);
    //   })
    //   .catch((error)=>{
    //     console.log(error.name + ": " + error.message);
    //   })
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

