<template>
    <BooksList
        :books=all_books
        page_title="本を更新・削除する" >
        <!-- slot -->
        <div slot="book-edit" slot-scope="{ book }">
            <FormInput
                v-model="book.title"
                label="タイトル"
                placeholder="8文字以上" />
            <FormInput
                v-model="book.author"
                label="著者"
                placeholder="8文字以上" />
            <FormInput
                v-model="book.volume"
                label="巻"
                placeholder="8文字以上" />
            <FormInput
                v-model="book.series"
                label="シリーズ"
                placeholder="8文字以上" />
            <FormInput
                v-model="book.publisher"
                label="出版"
                placeholder="8文字以上" />
            <FormInput
                v-model="book.pubdate"
                label="出版日"
                placeholder="8文字以上" />
            <!-- <FormTextarea
                v-model="book.detail"
                label="詳細" /> -->
            <FormButton
                button_name="更新する"
                @signalEvent="updateBook(book)" />
            <FormButton
                button_name="削除する"
                @signalEvent="destroyBook(book)" />
        </div>
    </BooksList>
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
        ...mapActions("Book", ["getAllBooks", "updateBook", "destroyBook"])
    }
}
</script>


<style lang="scss" scoped>
// PC
@media screen and (min-width: 640px) {
}
</style>
