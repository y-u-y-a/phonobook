<template>
    <BooksList page_title="本の一覧" :books_data=books></BooksList>
</template>


<script>

import BooksList from "../../components/BooksList.vue"

export default {

    components: {
        BooksList
    },

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
