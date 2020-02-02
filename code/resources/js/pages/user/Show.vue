<template>
  <div id="userShow">
    <p class="pageName">{{loginUser.name}}さんが借りている本</p>
    <button class="logoutButton" type="submit" @click="logout()">ログアウトする</button>
    <ul class="books-container">
      <li class="book-wrapper" v-for="book in booksBorrowed">
        <div class="book">
          <a :href="'/book/show/' + book.id">
            <img :src="book.cover" alt="No Image" />
          </a>
          <!-- classはinteger不可、idで指定する -->
          <!-- 以下のみlist.vueの異なる部分 -->
          <div class="returnButton">
            <button :id="book.id" type="submit" @click="returnBook">返却する</button>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loginUser: {},
      booksBorrowed: []
    };
  },

  created() {
    this.getBooksBorrowed();
    this.getLoginUser();
  },

  methods: {
    async logout() {
      await this.$store.dispatch("Auth/logout");
      // リダイレクト
      this.$router.push("/user/top");
    },


    // ログインユーザー情報の取得
    getLoginUser() {
      var axios = require("axios");
      axios.get("/api/users/logined")
        .then(response => {
          this.loginUser = response.data;
        })
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    },


    // 借りている本を取得
    getBooksBorrowed() {
      var axios = require("axios");
      axios.get("/api/books/borrowed")
        .then(response => {
          this.booksBorrowed = response.data;
        })
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    },


    // 本の返却
    returnBook() {
      // クリックした要素のidを取得する
      var book_id = event.target.id;
      var axios = require("axios");
      axios.get("/api/books/return/" + book_id)
        .then(response => {
          alert("返却しました");
          // 現在のページをリロード
          location.reload();
        })
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    }
  }
};
</script>


<style lang="scss" scoped>
$white: white;
$light-red: #f8e0e0;
$light-blue: #cee3f6;

// PC
@media screen and (min-width: 640px) {
  // 左側 ======================
  .captureArea {
    text-align: center;
    background-color: $light-red;
  }
  // 右側 ======================
  .registerAreaWrapper {
    width: 90%;
    margin: 0 auto;
    padding-top: 20px;
  }
  .registerArea {
    background-color: $light-blue;
    .getData {
      // floatで無視された高さを有効にする
      overflow: auto;
      // テキスト
      .leftBox {
        width: 60%;
        float: left;
        li {
          margin-bottom: 30px;
          input,
          textarea {
            width: 100%;
            margin-top: 10px;
            font-size: 14px;
            border: none;
          }
        }
      }
      // 画像
      .rightBox {
        width: 40%;
        text-align: center;
        float: right;
        .rightBoxWrapper {
          margin-top: 25px;
          img {
            display: inline-block;
            width: 200px;
            height: 300px;
            background-color: $white;
          }
          .registerButton {
            display: inline-block;
            margin-top: 150px;
            button {
              display: inline-block;
              padding: 10px 40px;
              color: $white;
              font-size: 18px;
              text-decoration: none;
              border-radius: 25px;
              background-image: linear-gradient(#6795fd 0%, #67ceff 100%);
              box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.29);
              border-bottom: solid 4px #5e7fca;
              cursor: pointer;
            }
            button:hover {
              opacity: 0.7;
            }
            button:active {
              -webkit-transform: translateY(4px);
              transform: translateY(4px);
              box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.2);
              border-bottom: none;
            }
          }
        }
      }
    }
  }
}
</style>
