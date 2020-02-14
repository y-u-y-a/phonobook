<template>
    <div>
        <BooksList page_title="本を更新・削除する" :books=all_books>
            <!-- slot要素でnameを指定・slot-scopeで子コンポーネントから受け取る -->
            <div slot="book-edit" slot-scope="{ book }">
                <FormInput :value="book.title" @signalEvent="getTitle(book.id)" label="タイトル" placeholder="8文字以上" ></FormInput>
                <FormInput :value="book.author" @signalEvent="getAuthor(book.id)" label="著者" placeholder="8文字以上" ></FormInput>
                <FormInput :value="book.volume" @signalEvent="getVolume(book.id)" label="巻" placeholder="8文字以上" ></FormInput>
                <FormInput :value="book.series" @signalEvent="getSeries(book.id)" label="シリーズ" placeholder="8文字以上" ></FormInput>
                <FormInput :value="book.publisher" @signalEvent="getPublisher(book.id)" label="出版" placeholder="8文字以上" ></FormInput>
                <FormInput :value="book.pubdate" @signalEvent="getPubdate(book.id)" label="出版日" placeholder="8文字以上" ></FormInput>
                <FormTextarea :value="book.detail" @signalEvent="getDetail(book.id)" label="詳細"></FormTextarea>
                <FormButton button_name="更新する" @signalEvent="updateBook(book)"></FormButton>
                <FormButton button_name="削除する" @signalEvent="destroyBook(book)"></FormButton>
            </div>
        </BooksList>
    </div>
</template>


<script>

import BooksList from "../../components/BooksList.vue"
import FormInput from "../../components/form/Input.vue"
import FormTextarea from "../../components/form/Textarea.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        BooksList,
        FormInput,
        FormTextarea,
        FormButton
    },

    created() {
        this.getAllBooks()
    },

    computed: {
        ...mapState("Book", ["all_books"])
    },

    methods: {
        ...mapActions("Book", ["getAllBooks"]),

        // 子コンポーネントでの変化を取得
        getISBN(value, book_id){
            var book = this.books.find(book_id)
            book.isbn = value
        },
        getTitle(value, book_id){
            var book = this.books.find(book_id)
            book.title = value
        },
        getAuthor(value, book_id){
            var book = this.books.find(book_id)
            book.author = value
        },
        getVolume(value, book_id){
            var book = this.books.find(book_id)
            book.volume = value
        },
        getSeries(value, book_id){
            var book = this.books.find(book_id)
            book.series = value
        },
        getPublisher(value, book_id){
            var book = this.books.find(book_id)
            book.publisher = value
        },
        getPubdate(value, book_id){
            var book = this.books.find(book_id)
            book.pubdate = value
        },
        getDetail(value, book_id){
            var book = this.books.find(book_id)
            book.detail = value
        },
        getCover(value, book_id){
            var book = this.books.find(book_id)
            book.cover = value
        },

        // async updateBook(book) {
        //     var params = {
        //         id: book.id,
        //         title: book.title,
        //         author: book.author,
        //         status: book.status
        //     }
        //     await axios.patch("/api/books", params)
        //     .then(response => {
        //         alert("更新が成功しました")
        //         this.getBooks() // データの再取得
        //     })
        //     .catch(error => {
        //         console.log(error.name + ": " + error.message)
        //     })
        // },

        // async destroyBook(book) {
        //     await axios.delete("/api/books", {
        //             data: { id: book.id } // deleteメソッドを使う場合はdataキーが必要！
        //         })
        //     .then(response => {
        //         alert("削除しました")
        //         this.getBooks() // データの再取得
        //     })
        //     .catch(error => {
        //         console.log(error.name + ": " + error.message)
        //     })
        // }
    }
}
</script>


<style lang="scss" scoped>
// PC
@media screen and (min-width: 640px) {
}
</style>
