<template>
    <div id="book-new">
        <div class="half-box">
            <LiveCamera @signalEvent="getBookWithOpenBD" />
        </div>

        <div class="half-box wrapper">
            <div class="container clearfix">
                <div class="half-box">
                    <ul>
                        <li><FormInput v-model="book.title" label="タイトル" placeholder="8文字以上" /></li>
                        <li><FormInput v-model="book.author" label="著者" placeholder="8文字以上" /></li>
                        <li><FormInput v-model="book.volume" label="巻" placeholder="8文字以上" /></li>
                        <li><FormInput v-model="book.series" label="シリーズ" placeholder="8文字以上" /></li>
                        <li><FormInput v-model="book.publisher" label="出版" placeholder="8文字以上" /></li>
                        <li><FormInput v-model="book.pubdate" label="出版日" placeholder="8文字以上" /></li>
                        <li><FormTextarea v-model="book.detail" label="詳細" /></li>
                    </ul>
                </div>
                <div class="half-box">
                    <img :src="book.cover" :alt="book.title">
                </div>
            </div>
            <FormButton @signalEvent="registerBook(book)" button_name="登録する" class="button" />
        </div>
    </div>
</template>

<script>

import LiveCamera from "../../components/LiveCamera.vue"
import FormInput from "../../components/form/Input.vue"
import FormTextarea from "../../components/form/Textarea.vue"
import FormButton from "../../components/form/Button.vue"
import { mapActions } from 'vuex'

export default {

    components: {
        LiveCamera,
        FormInput,
        FormTextarea,
        FormButton
    },

    data(){
        return{
            book: {
                isbn      : "",
                title     : "",
                author    : "",
                volume    : "",
                series    : "",
                publisher : "",
                pubdate   : "",
                cover     : "/no_image.png",
                detail    : ""
            }
        }
    },

    // TODO: openBDでの処理をバックエンドへ移行
    methods:{

        ...mapActions("Book", ["registerBook"]),

        // isbnは, LiveCameraコンポーネントから取得
        getBookWithOpenBD(isbn){

            if(isbn == ""){
                return alert("ISBNを入力してください。")
            }
            if(isbn.length != 13){
                return alert("ISBNは13桁で入力してください。")
            }

            // アクセス開始
            const url  = "https://api.openbd.jp/v1/get?isbn=" + isbn

            $.getJSON(url, (reply) => {

                // アラートなし(LiveCameraの精度が△)
                if(reply[0] == null){
                    return
                }

                // 本データの取得
                var book = reply[0].summary
                var detail = reply[0].onix.CollateralDetail.TextContent

                this.book.isbn = isbn
                this.book.title = book.title
                this.book.author = book.author
                this.book.volume = book.volume
                this.book.series = book.series
                this.book.publisher = book.publisher
                this.book.pubdate = book.pubdate

                // detailがあれば取得
                if(detail !== undefined){
                    book.detail = detail[0].Text
                }

                // 存在すれば取得
                if(book.cover != ""){
                    this.book.cover = book.cover
                }

                console.log("最終データ", this.book)
            })
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

.wrapper{
    margin-top: 4rem;
}
.container{
    width: 90%;
    margin: 0 auto;
    padding: 2rem 0 4rem;
    background-color: $white;
    clear: both;
}
ul{
    width: 90%;
    margin: 0 auto;
}
img {
    display: block;
    height: 380px;
    width: 100%;
    margin: 0 auto;
    // border: 2px solid $green;
}
.button{
    margin-top: 1rem;
}
</style>
