<template>
    <div class="wm-90">
        <div class="py-2 b-font-24">{{ page_title }}</div>
        <ul class="row">
            <li
                v-for="(book, index) in books"
                :key="index"
                class="col-3 mb-1 text-center">
                <div class="wm-90 py-1 bg-white">
                    <router-link :to="'/book/Show/' + book.id">
                        <img
                            :src="book.cover"
                            :alt="book.title"
                            width="200"
                            height="290"
                            class="mb-1 pointer" />
                    </router-link>
                    <!-- bindで親に変数を渡す(画像の下のボタンなど) -->
                    <!-- /book/Index -->
                    <slot name="book-index" :book="book"></slot>
                    <!-- /book/Edit -->
                    <slot name="book-edit" :book="book"></slot>
                    <!-- /user/Show -->
                    <slot name="user-show" :book="book"></slot>
                </div>
            </li>
        </ul>
    </div>
</template>


<script>

export default {

    props: ["page_title", "books"]
}
</script>


<style lang="scss" scoped>

@import "../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {
    li {
        box-sizing: border-box; // width=青+padding
        a:hover {
            opacity: 0.7;
        }
    }
}
</style>
