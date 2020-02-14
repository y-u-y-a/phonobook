<template>
    <BooksList page_title="本の一覧" :books=all_books></BooksList>
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
        ...mapActions("Book", ["getAllBooks"])
    }
}
</script>
