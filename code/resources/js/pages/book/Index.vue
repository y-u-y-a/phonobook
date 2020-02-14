<template>
    <BooksList page_title="本の一覧" :books=all_books>
        <!-- slot要素でnameを指定・slot-scopeで子コンポーネントから受け取る -->
        <div slot="book-index" slot-scope="slotPlops" class="state">
            <div v-if="slotPlops.book.state==0" class="ok">貸出し可能</div>
            <div v-else class="ng">貸出し中</div>
        </div>
    </BooksList>
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


<style lang="scss" scoped>

@import "../../../sass/app.scss";

.state {
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 2px;
}
.ok {
    color: $green;
}
.ng {
    color: $red;
}
</style>
