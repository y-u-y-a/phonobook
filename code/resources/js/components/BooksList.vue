<template>
    <div id="books-list">
        <div class="page-title">{{ page_title }}</div>
        <ul>
            <li v-for="n in 50">
                <div class="book">
                    <a href="#"><img src="/no_image.png" alt="No Image" /></a>
                    <div v-if="page_title=='本の一覧'" class="state">貸し出し可能</div>
                    <FormButton v-else type="submit" button_name="返却する"></FormButton>
                </div>
            </li>
            <!-- index <li class="book-wrapper" v-for="book in books">
                <div class="book">
                    <a :href="'/book/show/' + book.id">
                        <img :src="book.cover" alt="No Image" />
                    </a>
                    <p :class="book.state" class="state">{{book.state}}</p>
                </div>
            </li> -->
            <!-- show <li class="book-wrapper" v-for="book in booksBorrowed">
                <div class="book">
                    <a :href="'/book/show/' + book.id">
                        <img :src="book.cover" alt="No Image" />
                    </a>
                    <div class="returnButton">
                        <button :id="book.id" type="submit" @click="returnBook">返却する</button>
                    </div>
                </div>
            </li> -->
        </ul>
    </div>
</template>


<script>

import FormButton from "./form/Button.vue"

export default {

    components: {
        FormButton
    },

    props: ["page_title", "books_data"]
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
            .state {
                font-size: 18px;
                font-weight: bold;
                letter-spacing: 2px;
            }
            .貸出し可能 {
                color: $green;
            }
            .貸出し中 {
                color: $red;
            }
        }
    }
}
</style>
