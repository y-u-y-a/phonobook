<template>
    <div>
        <!-- <BooksList page_title="本を更新・削除する" :books_data=books></BooksList> -->
        <h1>本の更新・削除</h1>
        <ul v-for="book in books">
            <li>
                <p>id：{{book.id}}</p>
                <p>作品名：
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
                        <button type="button" @click="updateBook(book.id, book.title, book.author, book.status)"
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
            books: []
        }
    },

    created() {
        this.getBooks()
    },

    methods: {
        getBooks() {
            var path = "/api/books"
            axios.get(path)
            .then(response => {
                this.books = response.data
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
            })
        },

        updateBook(book_id, book_title, book_author, book_status) {
            var path = "/api/books"
            var params = {
                id: book_id,
                title: book_title,
                author: book_author,
                status: book_status
            }
            axios.patch(path, params)
            .then(response => {
                alert("更新が成功しました")
                this.getBooks() // データの再取得
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
            })
        },

        destroyBook(book_id) {
            var path = "/api/books"
            axios.delete(path, {
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
