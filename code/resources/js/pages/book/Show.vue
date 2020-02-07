<template>
  <div id="bookShow">
    <div id="title">{{book.title}}</div>
    <div class="bookInfo">
      <div class="half-box">
        <ul class="bookContents">
          <li v-if="book.author    != undefined">著者 ：{{book.author}}</li>
          <li v-if="book.volume    != undefined">巻 ：{{book.volume}}</li>
          <li v-if="book.series    != undefined">シリーズ ：{{book.series}}</li>
          <li v-if="book.publisher != undefined">出版社 ：{{book.publisher}}</li>
          <li v-if="book.pubdate   != undefined">出版日 ：{{book.pubdate}}</li>
          <li v-if="book.detail    != undefined" id="detail">{{book.detail}}</li>
        </ul>
      </div>
      <div class="half-box">
        <img :src="book.cover" alt="No Image" />
        <div>
          <button class="lendButton" v-if="book.state == 0" @click="lendBook()">この本を借りる</button>
          <button>レビューする</button>
        </div>
      </div>
    </div>
    <div class="bookReview">
      <p>↓====== この本の評価 ======↓</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // パラメータで渡されたデータの取得
      book_id: this.$route.params.id,
      book: {}
    };
  },
  created() {
    this.getBook();
  },
  methods: {
    getBook() {
      var axios = require("axios");
      axios
        .get("/api/books/" + this.book_id)
        // 成功した場合
        .then(response => {
          this.book = response.data;
        })
        // 失敗した場合
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    },
    // 本を貸出す処理
    lendBook() {
      var axios = require("axios");
      axios
        .get("/api/books/lend/" + this.book_id)
        // 成功した場合
        .then(response => {
          if (response.data != "") {
            alert(`${response.data}\n返却日は〜です。`);
            location.href = "/list";
          } else {
            alert("ログインしてください");
            location.href = "/login";
          }
        })
        // 失敗した場合
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    }
  }
};
</script>


<style lang="scss" scoped>
$white: white;

// PC
@media screen and (min-width: 640px) {
  #bookShow {
    #title {
      width: 90%;
      margin: 0 auto;
      padding: 30px 0;
      font-size: 24px;
      font-weight: bold;
    }
    .bookInfo {
      width: 90%;
      margin: 0 auto;
      font-size: 0; // inline-blockによる隙間の削除
      background-color: $white;
      .leftArea,
      .rightArea {
        padding-top: 40px;
        display: inline-block;
        vertical-align: top; // inline-blockの上揃え
        font-size: 16px; // 0になっているので指定する
        text-align: center;
      }
      .leftArea {
        width: 60%;
        .bookContents {
          width: 90%;
          margin: 0 auto;
          li {
            margin-bottom: 50px;
            text-align: left;
          }
          #bookShow {
            padding-top: 20px;
            margin: 0; // 打ち消し
            font-size: 18px;
            letter-spacing: 2px;
          }
        }
      }
      .rightArea {
        width: 39%;
        padding: 40px 0;
        img {
          width: 200px;
          height: 300px;
          margin-bottom: 40px;
        }
      }
    }
    .bookReview {
      width: 90%;
      margin: 20px auto 0;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      background-color: $white;
    }
  }
}
</style>
