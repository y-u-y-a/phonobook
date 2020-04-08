<template>
    <BooksList
        :page_title="`${login_user.name}さんが現在借りている本`"
        :books=borrowed_books >
        <!-- slot -->
        <div slot="user-show" slot-scope="{ book }" class="py-1 bg-white" >
            <FormButton
                @trigger="returnBook(book)"
                button_name="返却する" />
        </div>
    </BooksList>
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
        }
    },

    computed: {
        ...mapState("User", ["login_user"]),
    },

    created() {
        this.getBorrowedBooks()
    },

    methods: {
        ...mapActions("Book", ["returnBook"]),

        // 借りている本を取得
        async getBorrowedBooks() {

            await axios.get(`/api/books/borrowed/${this.login_user.id}`)
            .then((response) => {
                this.borrowed_books = response.data
            })
        }
    }
}
</script>
