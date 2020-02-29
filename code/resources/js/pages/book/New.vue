<template>
    <div id="book-new">
        <div class="half-box">
            <Camera></Camera>
            <FormInput v-model="isbn" label="ISBN" placeholder="" ></FormInput>
            <FormButton @signalEvent="getBookData" button_name="取得する"></FormButton>
        </div>

        <div class="half-box wrapper">
            <div class="container clearfix">
                <div class="half-box">
                    <ul>
                        <li><FormInput v-model="title" label="タイトル" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput v-model="author" label="著者" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput v-model="volume" label="巻" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput v-model="series" label="シリーズ" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput v-model="publisher" label="出版" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput v-model="pubdate" label="出版日" placeholder="8文字以上" ></FormInput></li>
                        <li><FormTextarea v-model="detail" label="詳細"></FormTextarea></li>
                    </ul>
                </div>
                <div class="half-box">
                    <img :src="cover" alt="No Image">
                </div>
            </div>
            <FormButton @signalEvent="registerBook" button_name="登録する" class="button"></FormButton>
        </div>
    </div>
</template>

<script>

import Camera       from "../../components/Camera.vue"
import FormInput    from "../../components/form/Input.vue"
import FormTextarea from "../../components/form/Textarea.vue"
import FormButton   from "../../components/form/Button.vue"

export default{
    components: {
        Camera,
        FormInput,
        FormTextarea,
        FormButton
    },

    data(){
        return{
            isbn      : "9784798038094",
            title     : "",
            author    : "",
            volume    : "",
            series    : "",
            publisher : "",
            pubdate   : "",
            detail    : "",
            cover     : "/no_image.png",
        }
    },

    methods:{

        getBookData(){
            // openBDに送信するデータを定義
            const isbn = this.isbn
            const url  = "https://api.openbd.jp/v1/get?isbn=" + isbn

            if(isbn == ""){
                alert("ISBNを入力してください")
            }else if(isbn.length != 13){
                alert("ISBNは13桁で入力してください")
            }else{
                // アクセス開始
                $.getJSON(url, response => {
                    if(response[0] != null){
                        // 本データの取得
                        var book = response[0].summary
                        this.title = book.title
                        this.author = book.author
                        this.volume = book.volume
                        this.series = book.series
                        this.publisher = book.publisher
                        this.pubdate = book.pubdate
                        this.detail = response[0].onix.CollateralDetail.TextContent[0].Text
                        // 画像が存在すれば更新
                        if(book.cover != ""){
                            this.cover = book.cover
                        }
                    }else{
                        alert("本データが見つかりません")
                    }
                })
            }
        },

        registerBook(){
            var params = {
                isbn : this.isbn,
                title : this.title,
                author : this.author,
                volum : this.volume,
                series : this.series,
                publisher: this.publisher,
                pubdate : this.pubdate,
                detail : this.detail,
                cover : this.cover
            }
            axios.post("/api/books", params)
            .then((response)=>{
                alert("登録が完了しました")
                location.href = "/book/New"
                // this.$router.push("/book/New")
            })
            .catch((error, response)=>{
                console.log(error.name + ": " + error.message)
                alert("失敗しました")
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
    width: 90%;
    margin: 0 auto;
}
.button{
    margin-top: 1rem;
}
</style>
