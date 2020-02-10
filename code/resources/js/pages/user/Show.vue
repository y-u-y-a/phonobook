<template>
    <div id="users-books">
        <button type="submit" @click="logout">ログアウトする</button>
        <BooksList :page_title="`${login_user.name}さんが読んだ本の一覧`" :books_data=booksBorrowed></BooksList>
    </div>
</template>

<script>

import BooksList from "../../components/BooksList.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        BooksList
    },

    data() {
        return {
            booksBorrowed: []
        };
    },

    computed: {
        ...mapState("User", ["login_user"]),
    },

    created() {
        this.getBooksBorrowed()
    },

    methods: {
        async logout() {
            await this.$store.dispatch("User/logout")
            await this.$router.push("/")
        },

        // 借りている本を取得
        getBooksBorrowed() {
            axios.get("/api/books/borrowed")
            .then(response => {
                this.booksBorrowed = response.data
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
            })
        },

        // 本の返却
        returnBook() {
            // クリックした要素のidを取得する
            var book_id = event.target.id
            axios.get("/api/books/return/" + book_id)
            .then(response => {
                alert("返却しました")
                // 現在のページをリロード
                location.reload()
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
            })
        }
    }
}
</script>
