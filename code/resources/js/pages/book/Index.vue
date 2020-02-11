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
        }
    },
    created() {
        this.getBooks()
    },
    methods: {
        getBooks() {
            axios.get("/api/books/all") // 戻り値をJSONで取得
            .then(response => {
                this.books = response.data
                // stateを文字列に変換
                this.books.forEach(function(book){
                    if (book.state == 0) {
                        book.state = "貸出し可能"
                    } else {
                        book.state = "貸出し中"
                    }
                })
            })
            .catch(error => {
                console.log(error.name + ": " + error.message);
            })
        }
    }
};
</script>
