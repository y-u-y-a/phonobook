<template>
    <div id="users-books">
        <button type="submit" @click="logout">ログアウトする</button>
        <BooksList page_title="ジョンソンさんが借りている本" :books_data=booksBorrowed></BooksList>
    </div>
</template>

<script>
import BooksList from "../../components/BooksList.vue"

export default {

    components: {
        BooksList
    },

    data() {
        return {
            loginUser: {},
            booksBorrowed: []
        };
    },

    created() {
        this.getBooksBorrowed();
        this.getLoginUser();
    },

    methods: {
        async logout() {
            await this.$store.dispatch("Auth/logout");
            // リダイレクト
            this.$router.push("/user/top");
        },


        // ログインユーザー情報の取得
        getLoginUser() {
            var axios = require("axios");
            axios.get("/api/users/logined")
                .then(response => {
                    this.loginUser = response.data;
                })
                .catch(error => {
                    console.log(error.name + ": " + error.message);
                });
        },


        // 借りている本を取得
        getBooksBorrowed() {
            var axios = require("axios");
            axios.get("/api/books/borrowed")
                .then(response => {
                    this.booksBorrowed = response.data;
                })
                .catch(error => {
                    console.log(error.name + ": " + error.message);
                });
        },


        // 本の返却
        returnBook() {
            // クリックした要素のidを取得する
            var book_id = event.target.id;
            var axios = require("axios");
            axios.get("/api/books/return/" + book_id)
                .then(response => {
                    alert("返却しました");
                    // 現在のページをリロード
                    location.reload();
                })
                .catch(error => {
                    console.log(error.name + ": " + error.message);
                });
        }
    }
};
</script>
