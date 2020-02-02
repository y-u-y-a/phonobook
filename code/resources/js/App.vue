<template>
  <div class="wrapper">
    <Header />
    <main>
      <RouterView />
    </main>
    <Footer />
  </div>
</template>


<script>
import Header from "./components/Header";
import Footer from "./components/Footer";

export default {
  components: {
    Header,
    Footer
  }
};
</script>


<style lang="scss">
// とりあえず =======================================
$black: #2e2e2e;
$white: white;
$gray: gray;
$silver: silver;
$light-silver: #f2f2f2;
$green: #04b431;
$red: #fe2e64;
$link-blue: #5882fa;
$link-red: #fa5858;
$light-red: #f8e0e0;
$light-blue: #cee3f6;

// PC
@media screen and (min-width: 640px) {
  main {
    // 最小の高さを指定(これより大きくなったら自動的に高さがます)
    // 子要素には継承しない
    min-height: calc(100vh - 100px - 50px);
  }
  /* 左右にエリアがある場合 */
  .leftArea,
  .rightArea {
    width: 50%;
    min-height: calc(
      100vh - 100px - 50px
    ); // 親要素が継承できなかったので、同じもの記述
  }
  .leftArea {
    float: left;
  }
  .rightArea {
    float: right;
  }

  /* ユーザー登録とログインページで共通部分 */
  .form {
    text-align: center;
    p {
      padding: 30px 50px;
      font-size: 24px;
      font-weight: bold;
      border-bottom: 1px solid $light-silver;
    }
    .form-wrapper {
      padding: 30px 0;
      .form-input {
        margin-bottom: 50px;
        text-align: center;
        label {
          font-size: 18px;
        }
        input {
          font-size: 18px;
        }
      }
    }
  }
  /* リッチなボタン */
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

// ログインページと借りるページ ====================
#userLogin,
#bookBorrow {
  // 左側
  .capture-wrapper {
    margin: 50px;
    text-align: center;
    video,
    canvas {
      background-color: $white;
      border: 1px solid $silver;
    }
  }
  // 右側(login.vue)
  .login-wrapper {
    // 余白作り
    margin: 50px;
    background-color: $white;
  }
  // 右側(borrow.vue)
  .borrow-wrapper {
    // 余白作り
    margin: 40px 50px;
    background-color: $white;
    text-align: center;
    .getBook {
      padding: 30px 0 0;
      .borrower-wrapper {
        display: inline-block;
        width: 285px;
        padding-bottom: 20px;
        text-align: left;
        span {
          display: block;
        }
        .disable {
          color: $red;
          font-weight: bold;
          font-size: 17px;
        }
        .able {
          color: $green;
          font-weight: bold;
          font-size: 17px;
        }
      }
      .bookCover {
        img {
          width: 275px;
          height: 375px;
        }
        .disable {
          border: 5px solid $red;
        }
        .able {
          border: 5px solid $green;
        }
      }
    }
    .borrowButton {
      padding: 30px 0 20px;
    }
  }
}
// 本の一覧ページとマイページ ============================
#bookIndex,
#userShow {
  .pageName {
    width: 90%;
    margin: 0 auto;
    padding: 30px 0;
    font-size: 24px;
    font-weight: bold;
  }
  .books-container {
    width: 90%;
    margin: 0 auto 50px;
    clear: both;
    .book-wrapper {
      display: inline-block;
      width: 25%;
      margin-bottom: 50px;
      text-align: center;
      .book {
        display: inline-block;
        padding: 20px 40px;
        background-color: $white;
        a {
          cursor: pointer;
        }
        a:hover {
          opacity: 0.7;
        }
        img {
          width: 200px;
          height: 290px;
        }
        p {
          padding-top: 20px;
        }
        .state {
          font-size: 18px;
          font-weight: bold;
          letter-spacing: 2px;
        }
        .貸出し可能 {
          color: $green;
        }
        .貸出し中 {
          color: $red;
        }
      }
    }
  }
}
#userShow {
  .returnButton {
    padding-top: 20px;
  }
}
</style>
