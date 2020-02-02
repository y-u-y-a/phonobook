<template>
  <div id="userLogin">
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
    </div>

    <div class="rightArea">
      <div class="login-wrapper">
        <form class="form" @submit.prevent="loginUser">
          <p>ログインする</p>
          <div class="form-wrapper">
            <input type="hidden" name="_token" :value="csrf" />
            <div class="email form-input">
              <label>メールアドレス：</label>
              <input type="text" v-model="email" placeholder="メールアドレス" autocomplete="off" />
            </div>
            <div class="password form-input">
              <label>パスワード：</label>
              <input type="password" v-model="password" placeholder="パスワード" autocomplete="off" />
            </div>
            <div class="loginButton">
              <button type="submit">ログインする</button>
            </div>
          </div>
        </form>
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
      capture: "",
      csrf: document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content"),
      email: "",
      password: ""
    };
  },

  mounted() {
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
    // カメラの起動
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

  methods: {
    takeFaceImage() {
      // 動画から画像の切り取り(2Dで)
      var ctx = this.canvas.getContext("2d");
      // カメラ→画像に変換
      ctx.drawImage(this.video, 0, 0, this.canvas.width, this.canvas.height);

      // 撮影した画像の処理 ===========================
      var type = "image/jpeg";
      // base64として取得する
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
      axios
        .post("/api/users/authFace", params)
        .then(response => {
          var user = response.data;
          if (!user) {
            alert("社員データが存在しません");
          } else {
            // 本人データの取得(arrival.vueと異なる部分)
            this.email = user.email;
            this.password = "";
          }
        })
        .catch(error => {
          alert("顔の撮影が必要です");
          console.log(error.name + ": " + error.message);
        });
    },

    // ユーザーのログイン
    async loginUser() {
      var params = {
        email: this.email,
        password: this.password
      };
      await this.$store
        .dispatch("Auth/login", params)
        // 成功した場合
        .then(response => {
          alert("ログインしました");
          this.$router.push("/");
        })
        // 失敗した場合
        .catch(error => {
          console.log(error.name + ": " + error.message);
          alert("ログインに失敗しました");
        });
    }
  }
};
</script>
