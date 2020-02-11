<template>
    <div>
        <BooksList page_title="本を更新・削除する" :books=all_books></BooksList>
    </div>
</template>


<script>

import BooksList from "../../components/BooksList.vue"
import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        BooksList
    },

    created() {
        this.getAllBooks()
    },

    computed: {
        ...mapState("Book", ["all_books"])
    },

    methods: {
        ...mapActions("Book", ["getAllBooks"]),

        async updateBook(book_id, book_title, book_author, book_status) {
            var params = {
                id: book_id,
                title: book_title,
                author: book_author,
                status: book_status
            }
            await axios.patch("/api/books", params)
            .then(response => {
                alert("更新が成功しました")
                this.getBooks() // データの再取得
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
            })
        },

        async destroyBook(book_id) {
            await axios.delete("/api/books", {
                    data: { id: book_id } // deleteメソッドを使う場合はdataキーが必要！
                })
            .then(response => {
                alert("削除しました")
                this.getBooks() // データの再取得
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
            })
        }
    }
}
</script>


<style lang="scss" scoped>
// PC
@media screen and (min-width: 640px) {
}
</style>
