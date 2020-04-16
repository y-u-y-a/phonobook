<template>
  <div class="row flex-x-center">
    <div class="col-md-10 mt-3">
      <ul class="flex-column">
        <li
          v-for="book in all_books"
          :key="book.title"
          class="row flex-justify-around pt-2 pb-1 mb-2 bg-white"
        >
          <div class>
            <img
              :src="book.cover"
              :alt="book.title"
              width="300px"
              height="450px"
              class="d-block shadow"
            />
            <div class="row flex-justify-around my-3">
              <FormButton button_name="更新する" @trigger="updateBook(book)" />
              <FormButton button_name="削除する" @trigger="destroyBook(book)" />
            </div>
          </div>
          <div class="flex-column col-md-7 px-1">
            <FormInput v-model="book.title" label="タイトル" placeholder="" />
            <FormInput v-model="book.author" label="著者" placeholder="" />
            <FormInput v-model="book.volume" label="巻" placeholder="" />
            <FormInput v-model="book.series" label="シリーズ" placeholder="" />
            <FormInput v-model="book.publisher" label="出版" placeholder="" />
            <FormInput v-model="book.pubdate" label="出版日" placeholder="" />
            <FormTextarea v-model="book.detail" label="詳細" />
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>


<script>
import FormInput from "../../components/form/Input.vue";
import FormTextarea from "../../components/form/Textarea.vue";
import FormButton from "../../components/form/Button.vue";

import { mapState, mapGetters, mapActions } from "vuex";

export default {
  components: {
    FormInput,
    FormTextarea,
    FormButton
  },

  created() {
    this.getAllBooks();
  },

  computed: {
    ...mapState("Book", ["all_books"])
  },

  methods: {
    ...mapActions("Book", ["getAllBooks", "updateBook", "destroyBook"])
  }
};
</script>
