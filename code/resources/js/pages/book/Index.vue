<template>
  <BooksList page_title="本の一覧" :books="all_books">
    <!-- slot-scopeでデータ取得 -->
    <div
        slot="bottom-section"
        slot-scope="slotPlops"
        class="py-1 b-font-18 letter-2 bg-white">
      <div v-if="slotPlops.book.state==0" class="ok">貸出し可能</div>
      <div v-else class="ng">貸出し中</div>
    </div>
  </BooksList>
</template>


<script>
import BooksList from "../../components/BooksList.vue";

import { mapState, mapGetters, mapActions } from "vuex";

export default {
  components: {
    BooksList
  },

  created() {
    this.getAllBooks();
  },

  computed: {
    ...mapState("Book", ["all_books"])
  },

  methods: {
    ...mapActions("Book", ["getAllBooks"])
  }
};
</script>


<style lang="scss" scoped>
@import "../../../sass/app.scss";

.ok {
  color: $green;
}
.ng {
  color: $red;
}
</style>
