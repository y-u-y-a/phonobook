<template>
    <div class="row flex-x-center font-20">
        <div class="col-md-10">

            <header class="my-4 b-font-24">{{ book.title }}</header>

            <div class="row py-2 bg-white">
                <ul class="col-md-7 px-2">
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
                    <li>
                        <FormRichButton
                            v-if="book.state==0"
                            @trigger="borrowBook({
                                isbn: book.isbn,
                                auth_user: login_user,
                                dest: '/book/Index'
                            })"
                            button_name="この本を借りる" />
                    </li>
                </ul>
                <div class="col-md-5 text-center">
                    <img
                        :src="book.cover"
                        :alt="book.title"
                        width="250px"
                        height="375px"
                        class="shadow" />
                    <!-- <FormRichButton button_name="レビューする" /> -->
                </div>
            </div>
        </div>
        <!-- <div class="py-2 t-dashed-silver-1 text-center">↓ ============　この本の評価　============ ↓</div> -->
    </div>
</template>


<script>

import FormRichButton from "../../components/form/RichButton.vue"
import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        FormRichButton
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
