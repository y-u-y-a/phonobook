<template>
    <div id="adminBook">
        <!-- 左側 ============ -->
        <div class="leftArea captureArea">
            <h1>番号入力またはバーコードを撮影してください</h1>
            <div class="inputISBN">
                <input v-model="isbn">
                <button @click="getISBN()">取得する</button>
            </div>
        </div>
        <!-- 右側 ============= -->
        <div class="rightArea registerArea">
            <div class="registerAreaWrapper">

                <div class="getData">
                    <ul class="leftBox">
                        <li>
                            <label>書籍名</label>
                            <br>
                            <textarea id="title" type="text" v-model="title"></textarea>
                        </li>
                        <li>
                            <label>著者</label>
                            <br>
                            <input id="author" type="text" v-model="author">
                        </li>
                        <li>
                            <label>巻</label>
                            <br>
                            <input id="volume" type="text" v-model="volume">
                        </li>
                        <li>
                            <label>シリーズ</label>
                            <br>
                            <input id="series" type="text" v-model="series">
                        </li>
                        <li>
                            <label>出版</label>
                            <br>
                            <input id="publisher" type="text" v-model="publisher">
                        </li>
                        <li>
                            <label>出版日</label>
                            <br>
                            <input id="pubdate" type="text" v-model="pubdate">
                        </li>
                        <li>
                            <label>詳細</label>
                            <br>
                            <textarea id="detail" type="text" v-model="detail"></textarea>
                        </li>
                    </ul>
                    <div class="rightBox">
                        <div class="rightBoxWrapper">
                            <div id="cover">
                                <img :src="cover" alt="No Image">
                            </div>
                            <div class="registerButton">
                                <input type="hidden" name="_token" :value="csrf">
                                <button type="submit" @click="registerBook()">登録する</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                csrf      : document.querySelector("meta[name='csrf-token']").getAttribute("content"),
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
            // ISBNの取得 =============================================================
            getISBN(){
                // openBDに送信するデータを定義
                const isbn = this.isbn;
                const url  = "https://api.openbd.jp/v1/get?isbn=" + isbn;
                // 関数内ではthisが他を指すことがあるので、予め変数に代入しておく
                var vm = this;

                if(isbn == ""){
                    alert("ISBNを入力してください");
                }else if(isbn.length != 13){
                    alert("ISBNは13桁で入力してください");
                }else{
                    // アクセス開始
                    $.getJSON(url, function(data){ // dataは,APIからの返り値
                        if(data[0] != null){
                            // 本データの取得
                            var book = data[0].summary;
                            // dataの更新
                            vm.title = book.title;
                            vm.author = book.author;
                            vm.volume = book.volume;
                            vm.series = book.series;
                            vm.publisher = book.publisher;
                            vm.pubdate = book.pubdate;
                            vm.detail = data[0].onix.CollateralDetail.TextContent[0].Text;
                            // 画像が存在すれば更新する
                            if(book.cover != ""){
                                vm.cover = book.cover;
                            }
                        }else{
                            alert("データが見つかりません");
                        }
                    });
                }
            },
            // 本の登録 ===============================================================
            registerBook(){

                var axios  = require("axios");
                var path   = "/api/books";
                var params = {
                    isbn : this.isbn,
                    title : this.title,
                    author : this.author,
                    volum  : this.volume,
                    series : this.series,
                    publisher: this.publisher,
                    pubdate : this.pubdate,
                    detail : this.detail,
                    cover : this.cover
                };
                axios.post(path, params)
                // 成功した場合
                .then((response)=>{
                    alert("登録が完了しました");
                    location.href = "/admin/book";
                })
                // 失敗した場合
                .catch((error, response)=>{
                    console.log(error.name + ": " + error.message);
                    alert("失敗しました");
                })
            }
        }
    };
</script>
