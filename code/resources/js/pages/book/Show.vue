<template>
    <div class="bg-white">
        <div class="row wm-90 pb-2 b-dashed-silver-1">
            <div class="py-4 b-font-24">{{ book.title }}</div>
            <ul class="col-7 font-16">
                <li
                    v-if="book.author!=undefined"
                    class="mb-2">
                著者 ：{{ book.author }}</li>
                <li
                    v-if="book.volume!=undefined"
                    class="mb-2">
                巻 ：{{ book.volume }}</li>
                <li
                    v-if="book.series!=undefined"
                    class="mb-2">
                シリーズ ：{{ book.series }}</li>
                <li
                    v-if="book.publisher!=undefined"
                    class="mb-2">
                出版社 ：{{ book.publisher }}</li>
                <li
                    v-if="book.pubdate!=undefined"
                    class="mb-2">
                出版日 ：{{ book.pubdate }}</li>
                <li
                    v-if="book.detail!=undefined"
                    class="mb-2">
                {{ book.detail }}</li>
            </ul>
            <div class="col-5 text-center">
                <img
                    :src="book.cover"
                    alt="No Image"
                    class="d-block wm-60" />
                <FormButton
                    v-if="book.state==0"
                    @signalEvent="borrowBook({
                        isbn: book.isbn,
                        auth_user: login_user,
                        dest: '/book/Index'
                    })"
                    button_name="この本を借りる"
                    class="mt-2" />
                <!-- <FormButton button_name="レビューする" /> -->
            </div>
        </div>
        <div class="text-center">↓ ============　この本の評価　============ ↓</div>
    </div>
</template>


<script>

import FormButton from "../../components/form/Button.vue"
import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        FormButton
    },

    async created() {
        await this.getAllBooks()
        await this.getBookById(this.$route.params.id) // パラメータから取得
    },

    computed: {
        ...mapState("User", ["login_user"]),
        ...mapState("Book", ["book"])
    },

    methods: {

        ...mapActions("Book", ["getAllBooks", "getBookById", "borrowBook"])

    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {
}
</style>
