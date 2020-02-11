<template>
    <div id="book-show">
        <div class="book-info clearfix">
            <div class="title">{{ book.title }}</div>
            <div class="half-box">
                <ul>
                    <li v-if="book.author!=undefined">著者 ：{{ book.author }}</li>
                    <li v-if="book.volume!=undefined">巻 ：{{ book.volume }}</li>
                    <li v-if="book.series!=undefined">シリーズ ：{{ book.series }}</li>
                    <li v-if="book.publisher!=undefined">出版社 ：{{ book.publisher }}</li>
                    <li v-if="book.pubdate!=undefined">出版日 ：{{ book.pubdate }}</li>
                    <li v-if="book.detail!=undefined">{{ book.detail }}</li>
                </ul>
            </div>
            <div class="half-box image-box">
                <img :src="book.cover" alt="No Image" />
                <FormButton v-if="book.state == 0" @signalEvent="lendBook" button_name="この本を借りる" class=
                "button"></FormButton>
                <!-- <FormButton button_name="レビューする"></FormButton> -->
            </div>
        </div>
        <div class="book-review">↓ ============　この本の評価　============ ↓</div>
    </div>
</template>


<script>

import FormButton from "../../components/form/Button.vue"
import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        FormButton
    },

    async created() {
        await this.getAllBooks()
        await this.getBookById(this.$route.params.id) // パラメータから取得
    },

    computed: {
        ...mapState("Book", ["book"])
    },

    methods: {
        ...mapActions("Book", ["getAllBooks", "getBookById"]),

        // 本を貸出す処理
        lendBook() {
            axios.get("/api/books/lend/" + this.book.id)
            .then(response => {
                if (response.data != "") {
                    alert(`${response.data}\n返却日は〜です。`)
                    location.href = "/list"
                } else {
                    alert("ログインしてください")
                    location.href = "/login"
                }
            })
            .catch(error => {
                console.log(error.name + ": " + error.message)
            })
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {
    #book-show {
        background: $white;
    }
    .book-info{
        padding-bottom: 2rem;
        border-bottom: 1px dashed $silver;
        .title {
            width: 90%;
            margin: 0 auto;
            padding: 30px 0;
            font-size: 24px;
            font-weight: bold;
        }
        ul{
            width: 80%;
            margin: 0 auto;
            font-size: 16px;
            li{
                margin-bottom: 2rem;
            }
        }
        .image-box{
            text-align: center;
        }
        .button{
            margin-top: 2rem;
        }
    }
    .book-review{
        text-align: center;
    }
}
</style>
