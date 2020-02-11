<template>
    <div id="book-new">
        <div class="half-box">
            <Camera></Camera>
            <FormInput v-model="isbn" label="番号入力またはバーコードを撮影してください" placeholder="8文字以上" ></FormInput>
            <FormButton @signalEvent="getISBN" button_name="取得する"></FormButton>
        </div>

        <div class="half-box wrapper">
            <div class="container clearfix">
                <div class="half-box">
                    <ul>
                        <li><FormInput label="書籍名" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput label="著者" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput label="巻" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput label="シリーズ" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput label="出版" placeholder="8文字以上" ></FormInput></li>
                        <li><FormInput label="出版日" placeholder="8文字以上" ></FormInput></li>
                        <li><FormTextarea label="詳細"></FormTextarea></li>
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

        getISBN(){
            // openBDに送信するデータを定義
            const isbn = this.isbn
            const url  = "https://api.openbd.jp/v1/get?isbn=" + isbn
            // 関数内ではthisが他を指すことがあるので、予め変数に代入しておく
            var vm = this

            if(isbn == ""){
                alert("ISBNを入力してください")
            }else if(isbn.length != 13){
                alert("ISBNは13桁で入力してください")
            }else{
                // アクセス開始
                $.getJSON(url, function(data){ // dataは,APIからの返り値
                    if(data[0] != null){
                        // 本データの取得
                        var book = data[0].summary
                        // dataの更新
                        vm.title = book.title
                        vm.author = book.author
                        vm.volume = book.volume
                        vm.series = book.series
                        vm.publisher = book.publisher
                        vm.pubdate = book.pubdate
                        vm.detail = data[0].onix.CollateralDetail.TextContent[0].Text
                        // 画像が存在すれば更新する
                        if(book.cover != ""){
                            vm.cover = book.cover
                        }
                    }else{
                        alert("データが見つかりません")
                    }
                })
            }
        },

        registerBook(){
            var path   = "/api/books"
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
            axios.post(path, params)
            // 成功した場合
            .then((response)=>{
                alert("登録が完了しました")
                location.href = "/admin/book"
            })
            // 失敗した場合
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
