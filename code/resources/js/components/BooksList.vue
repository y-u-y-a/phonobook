<template>
    <div id="books-list">
        <div class="page-title">{{ page_title }}</div>
        <ul>
            <li v-for="book in books">
                <div class="book">
                    <router-link :to="'/book/Show/' + book.id">
                        <img :src="book.cover" alt="No Image" />
                    </router-link>

                    <!-- /book/Index -->
                    <div v-if="page_title=='本の一覧'" class="state">
                        <div v-if="book.state==0" class="ok">貸出し可能</div>
                        <div v-else class="ng">貸出し中</div>
                    </div>
                    <!-- /book/Edit -->
                    <div v-else-if="page_title=='本を更新・削除する'">
                        <FormButton button_name="更新する"></FormButton>
                        <FormButton button_name="削除する"></FormButton>
                    </div>
                    <!-- /user/Show -->
                    <FormButton v-else button_name="返却する"></FormButton>
                </div>
            </li>
        </ul>
    </div>
</template>


<script>

import FormButton from "./form/Button.vue"

export default {

    components: {
        FormButton
    },

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
        }
    }
}
</style>
