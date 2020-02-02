<template>
  <div>
    <h1>本の更新・削除をする</h1>
    <input type="hidden" name="_token" :value="csrf" />
    <ul v-for="book in books">
      <li>
        <p>id：{{book.id}}</p>
        <p>
          作品名：
          <input v-model="book.title" />
        </p>
        <p>
          著者名：
          <input v-model="book.author" />
        </p>
        <p>
          貸出し：
          <input v-model="book.status" />
        </p>
        <ul>
          <li>
            <button
              type="button"
              @click="updateBook(book.id, book.title, book.author, book.status)"
            >更新する</button>
          </li>
          <li>
            <button type="button" @click="destroyBook(book.id)">削除する</button>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>


<script>
export default {
  data() {
    return {
      csrf: document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content"),
      books: []
    };
  },
  // DOM生成前に本データを取得
  created() {
    this.getBooks();
  },
  methods: {
    // 本データの取得 ==========================================================
    getBooks() {
      var axios = require("axios");
      var path = "/api/books";
      axios
        .get(path)
        // 成功した場合
        .then(response => {
          this.books = response.data;
        })
        // 失敗した場合
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    },
    // 本データの更新 ==========================================================
    updateBook(book_id, book_title, book_author, book_status) {
      var axios = require("axios");
      var path = "/api/books";
      var params = {
        id: book_id,
        title: book_title,
        author: book_author,
        status: book_status
      };
      axios
        .patch(path, params)
        // 成功した場合
        .then(response => {
          alert("更新が成功しました");
          this.getBooks(); // データの再取得
        })
        // 失敗した場合
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    },
    // 本データの削除 ==========================================================
    destroyBook(book_id) {
      var axios = require("axios");
      var path = "/api/books";
      axios
        .delete(path, {
          data: { id: book_id } // deleteメソッドを使う場合はdataキーが必要！
        })
        // 成功した場合
        .then(response => {
          alert("削除しました");
          this.getBooks(); // データの再取得
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
// PC
@media screen and (min-width: 640px) {
}
</style>
