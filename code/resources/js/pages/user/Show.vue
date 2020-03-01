<template>
    <div id="users-books">
        <div class="form">
            <FormButton @signalEvent="logout" button_name="ログアウトする"></FormButton>
        </div>
        <BooksList :page_title="`${login_user.name}さんが読んだ本の一覧`" :books=borrowed_books>
            <!-- slot要素でnameを指定 -->
            <slot name="user-show">
                <FormButton button_name="返却する"></FormButton>
            </slot>
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
        logout() {
            console.log(this.login_user)
            this.$store.dispatch("User/logout")
            location.href = "/"
        },

        // 借りている本を取得
        getBorrowedBooks() {

            axios.get("/api/books/borrowed")
            .then((response) => {
                this.borrowed_books = response.data
            })
            .catch((error) => {
                console.log(error.name + ": " + error.message)
            })
        },

        // 本の返却
        returnBook(e) {

            // クリックした要素のidを取得
            var book_id = e.target.id

            axios.get("/api/books/return/" + book_id)
            .then((response) => {

                alert("返却しました")
                location.reload()
            })
            .catch((error) => {
                console.log(error.name + ": " + error.message)
            })
        }
    }
}
</script>
