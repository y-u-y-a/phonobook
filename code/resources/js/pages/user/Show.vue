<template>
    <div id="users-books">
        <div class="form">
            <FormButton @signalEvent="logout" button_name="ログアウトする" />
        </div>
        <BooksList :page_title="`${login_user.name}さんが現在借りている本`" :books=borrowed_books>
            <!-- BookListのuser-showにマウント/bookを取得 -->
            <div slot="user-show" slot-scope="{ book }">
                <FormButton @signalEvent="returnBook(book)" button_name="返却する" />
            </div>
        </BooksList>
    </div>
</template>


<script>

import BooksList from "../../components/BooksList.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        BooksList,
        FormButton
    },

    data() {
        return {
            borrowed_books: []
        };
    },

    computed: {
        ...mapState("User", ["login_user"]),
    },

    created() {
        this.getBorrowedBooks()
    },

    methods: {

        ...mapActions("User", ["logout"]),
        ...mapActions("Book", ["returnBook"]),

        // 借りている本を取得
        async getBorrowedBooks() {

            await axios.get("/api/books/borrowed/" + this.login_user.id)
            .then((response) => {
                this.borrowed_books = response.data
            })
            .catch((error) => {
                alert("エラーが発生しました。")
                console.log(error.name + ": " + error.message)
            })
        }
    }
}
</script>
