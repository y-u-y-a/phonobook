<template>
    <div id="books-list">
        <div class="page-title">{{ page_title }}</div>
        <ul>
            <li v-for="book in books">
                <div class="book">
                    <router-link :to="'/book/Show/' + book.id">
                        <img :src="book.cover" :alt="book.title" />
                    </router-link>
                    <!-- slotで使う要素を指定できる、bindで親に変数を渡す(画像の下のボタンなど) -->
                    <!-- /book/Index -->
                    <slot name="book-index" :book="book"></slot>
                    <!-- /book/Edit -->
                    <slot name="book-edit" :book="book"></slot>
                    <!-- /user/Show -->
                    <slot name="user-show"></slot>
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
    #books-list{
        width: 90%;
        margin: 0 auto;
    }
    .page-title {
        padding: 2rem 0;
        font-size: 24px;
        font-weight: bold;
    }
    li {
        display: inline-block;
        width: 25%;
        margin-bottom: 3rem;
        box-sizing: border-box; // width=青+padding
        padding: 0 10px;
        text-align: center;
        .book {
            padding: 1rem 0;
            background-color: $white;
            a:hover {
                opacity: 0.7;
                cursor: pointer;
            }
            img {
                width: 200px;
                height: 290px;
                margin-bottom: 1rem;
            }
        }
    }
}
</style>
