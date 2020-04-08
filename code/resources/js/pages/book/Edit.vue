<template>
    <div class="wm-90">
        <header class="py-2 b-font-24">本を更新・削除する</header>
        <ul class="flex-column">
            <li
                v-for="book in all_books"
                :key="book.title"
                class="row flex-justify-between p-2 mb-2 bg-white">
                <div class="pt-2 text-center">
                    <img
                        :src="book.cover"
                        :alt="book.title"
                        width="250"
                        height="350">
                    <div class="row flex-x-center my-3">
                        <FormRichButton
                            button_name="更新する"
                            @trigger="updateBook(book)" />
                        <FormRichButton
                            button_name="削除する"
                            @trigger="destroyBook(book)" />
                    </div>
                </div>
                <div class="flex-column col-md-7">
                    <FormInput
                        v-model="book.title"
                        label="タイトル"
                        placeholder="" />
                    <FormInput
                        v-model="book.author"
                        label="著者"
                        placeholder="" />
                    <FormInput
                        v-model="book.volume"
                        label="巻"
                        placeholder="" />
                    <FormInput
                        v-model="book.series"
                        label="シリーズ"
                        placeholder="" />
                    <FormInput
                        v-model="book.publisher"
                        label="出版"
                        placeholder="" />
                    <FormInput
                        v-model="book.pubdate"
                        label="出版日"
                        placeholder="" />
                    <FormTextarea
                        v-model="book.detail"
                        label="詳細" />
                </div>
            </li>
        </ul>
    </div>
</template>


<script>

import FormInput from "../../components/form/Input.vue"
import FormTextarea from "../../components/form/Textarea.vue"
import FormRichButton from "../../components/form/RichButton.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        FormInput,
        FormTextarea,
        FormRichButton
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
