<template>
    <div class="wm-90">
        <header class="py-2 b-font-24">{{ page_title }}</header>
        <ul class="row flex-justify-between">
            <li
                v-for="book in books"
                :key="book.id"
                class="flex-x-center col-md-3 mb-2">
                <div class="text-center shadow">
                    <router-link
                        tag="img"
                        :to="'/book/Show/' + book.id"
                        :src="book.cover"
                        :alt="book.title"
                        width="230"
                        height="300"
                        class="pointer" />
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
