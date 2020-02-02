<template>
  <div id="bookIndex">
    <p class="pageName">本の一覧</p>
    <ul class="books-container">
      <li class="book-wrapper" v-for="book in books">
        <div class="book">
          <a :href="'/book/show/' + book.id">
            <img :src="book.cover" alt="No Image" />
          </a>
          <p :class="book.state" class="state">{{book.state}}</p>
        </div>
      </li>
    </ul>
  </div>
</template>


<script>
export default {
  data() {
    return {
      books: []
    };
  },
  created() {
    this.getBooks();
  },
  methods: {
    getBooks() {
      var axios = require("axios");
      axios
        .get("/api/books/all") // 作ったapi(Laravel側)の処理を実行し、戻り値をJSONで取得？
        // 成功した場合
        .then(response => {
          // responseを配列booksに代入する
          this.books = response.data;
          // stateを文字列に変換
          for (var i = 0; i < this.books.length; i++) {
            var book = this.books[i];
            if (book.state == 0) {
              book.state = "貸出し可能";
            } else {
              book.state = "貸出し中";
            }
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
$black: #2e2e2e;

// PC
@media screen and (min-width: 640px) {
}
</style>
