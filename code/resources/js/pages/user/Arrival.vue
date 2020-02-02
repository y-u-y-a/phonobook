<template>
  <div id="arrival">
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
      <div class="usersIndex-wrapper">
        <table class="usersIndex">
          <tr class="tableHeader">
            <th>名前</th>
            <th>出勤時間</th>
            <th>出勤状況</th>
          </tr>
          <tr v-for="user in users" :id="user.id">
            <td>{{user.name}}</td>
            <td>{{user.updated_at}}</td>
            <td>{{user.state}}</td>
          </tr>
        </table>
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
      users: []
    };
  },

  mounted() {
    this.setUpCamera();
  },
  created() {
    this.getAllUsers();
  },

  methods: {

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


    // 全てのユーザー取得
    getAllUsers() {
      var axios = require("axios");
      axios.get("/api/users/all")
        .then(response => {
          // 出勤状態を記号に変換
          this.users = response.data;
          for (var i = 0; i < this.users.length; i++) {
            var user = this.users[i];
            if (user.state == 0) {
              user.state = "×";
            } else {
              user.state = "◯";
            }
          }
        })
        // 失敗した場合
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    },


    // 動画から画像を取得
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

      // 撮影した画像の処理 ===========================
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
          var user = response.data;
          // DB内に存在 & スコア0.92以上の場合
          if (user) {
            this.changeState(user);
          }
          // nullだった場合
          else {
            alert("社員データが存在しません");
          }
        })
        .catch(error => {
          alert("顔の撮影が必要です");
          console.log(error.name + ": " + error.message);
        });
    },


    // 出退勤処理と表示データの更新
    changeState(user) {
      var params = {
        user_id: user.id
      };
      // 出退勤処理
      var axios = require("axios");
      axios.post("/api/users/state", params)
        .then(response => {
          // 表示データの更新
          this.getAllUsers();
          var element = document.getElementById(user.id);
          element.style.backgroundColor = "#F6CECE";
          element.scrollIntoView({
            behavor: "smooth"
          });
        })
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    }
  }
};
</script>


<style lang="scss" scoped>
$black: #2e2e2e;

// PC
@media screen and (min-width: 640px) {
  $light-blue: #cee3f6;
  $silver: silver;
  $white: white;
  // 左側
  .capture-wrapper {
    margin: 82px 50px 50px;
    text-align: center;
    video,
    canvas {
      background-color: $white;
      border: 1px solid $silver;
    }
  }
  // 右側
  .usersIndex-wrapper {
    // はみ出す要素の親要素に指定(高さを明示)
    height: calc(100vh - 100px - 50px);
    overflow: auto;
    margin: 0 50px;
    text-align: center;
    background-color: $white;
    p {
      padding: 25px 50px;
      font-size: 24px;
      font-weight: bold;
    }
    table {
      width: 100%;
      table-layout: fixed;
      border-collapse: separate;
      border-spacing: 2px;
    }
    tr,
    th,
    td {
      border: 1px solid $silver;
    }
    th {
      padding: 30px;
      letter-spacing: 10px;
      font-size: 18px;
      font-weight: bold;
      background-color: $light-blue;
    }
    td {
      padding: 30px 0;
    }
  }
}
</style>
