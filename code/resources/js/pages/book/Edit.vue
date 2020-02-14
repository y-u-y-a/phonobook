<template>
    <div>
        <BooksList page_title="本を更新・削除する" :books=all_books>
            <!-- slot要素でnameを指定・slot-scopeで子コンポーネントから受け取る -->
            <div slot="book-edit" slot-scope="slotProps">
                <FormInput :value="slotProps.book.title" @signalEvent="getTitle(slotProps.book.id)" label="タイトル" placeholder="8文字以上" ></FormInput>
                <FormInput :value="slotProps.book.author" @signalEvent="getAuthor(slotProps.book.id)" label="著者" placeholder="8文字以上" ></FormInput>
                <FormInput :value="slotProps.book.volume" @signalEvent="getVolume(slotProps.book.id)" label="巻" placeholder="8文字以上" ></FormInput>
                <FormInput :value="slotProps.book.series" @signalEvent="getSeries(slotProps.book.id)" label="シリーズ" placeholder="8文字以上" ></FormInput>
                <FormInput :value="slotProps.book.publisher" @signalEvent="getPublisher(slotProps.book.id)" label="出版" placeholder="8文字以上" ></FormInput>
                <FormInput :value="slotProps.book.pubdate" @signalEvent="getPubdate(slotProps.book.id)" label="出版日" placeholder="8文字以上" ></FormInput>
                <FormTextarea :value="slotProps.book.detail" @signalEvent="getDetail(slotProps.book.id)" label="詳細"></FormTextarea>
                <FormButton button_name="更新する" @signalEvent="updateBook"></FormButton>
                <FormButton button_name="削除する" @signalEvent="destroyBook"></FormButton>
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
            const book = this.books.find(book_id)
            book.isbn = value
        },
        getTitle(value, book_id){
            const book = this.books.find(book_id)
            book.title = value
        },
        getAuthor(value, book_id){
            const book = this.books.find(book_id)
            book.author = value
        },
        getVolume(value, book_id){
            const book = this.books.find(book_id)
            book.volume = value
        },
        getSeries(value, book_id){
            const book = this.books.find(book_id)
            book.series = value
        },
        getPublisher(value, book_id){
            const book = this.books.find(book_id)
            book.publisher = value
        },
        getPubdate(value, book_id){
            const book = this.books.find(book_id)
            book.pubdate = value
        },
        getDetail(value, book_id){
            const book = this.books.find(book_id)
            book.detail = value
        },
        getCover(value, book_id){
            const book = this.books.find(book_id)
            book.cover = value
        },

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
