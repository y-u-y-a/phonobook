<template>
    <div class="wm-90">
        <div class="row flex-justify-between p-2 bg-white">
            <!-- 左側 -->
            <div class="col-md-5">
                <FormInput
                    v-model="book.title"
                    label="タイトル"
                    placeholder="8文字以上" />
                <FormInput
                    v-model="book.author"
                    label="著者"
                    placeholder="8文字以上" />
                <FormInput
                    v-model="book.volume"
                    label="巻"
                    placeholder="8文字以上" />
                <FormInput
                    v-model="book.series"
                    label="シリーズ"
                    placeholder="8文字以上" />
                <FormInput
                    v-model="book.publisher"
                    label="出版"
                    placeholder="8文字以上" />
                <FormInput
                    v-model="book.pubdate"
                    label="出版日"
                    placeholder="8文字以上" />
                <FormTextarea
                    v-model="book.detail"
                    label="詳細" />
            </div>
            <!-- 右側 -->
            <div class="col-md-5 text-center">
                <img
                    :src="book.cover"
                    :alt="book.title"
                    height="450px"
                    width="100%"
                    class="d-block">
                <div class="flex-justify-between mt-2">
                    <FormRichButton
                        @trigger="modal_camera=true"
                        button_name="カメラ起動" />
                    <CodeReader @trigger="getBookFromOpenBD" />
                    <FormRichButton
                        @trigger="registerBook(book)"
                        button_name="登録する" />
                </div>
            </div>
        </div>

        <ModalCamera
            v-if="modal_camera"
            @trigger="modal_camera=false"
            camera_type="reader">
            <div slot="operate-message" class="c-white b-font-28">
                本のバーコードをかざしてください。
            </div>
        </ModalCamera>
    </div>
</template>

<script>

import ModalCamera from "../../modal/Camera.vue"
import CodeReader from "../../components/CodeReader.vue"
import FormInput from "../../components/form/Input.vue"
import FormTextarea from "../../components/form/Textarea.vue"
import FormRichButton from "../../components/form/RichButton.vue"

import { mapActions } from 'vuex'

export default {

    components: {
        ModalCamera,
        CodeReader,
        FormInput,
        FormTextarea,
        FormRichButton
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
            },
            modal_camera: false
        }
    },

    // TODO: openBDでの処理をバックエンドへ移行
    methods:{

        ...mapActions("Book", ["registerBook"]),

        // isbnは, CodeReaderコンポーネントから取得
        getBookFromOpenBD(isbn){

            if(isbn == ""){
                return alert("ISBNを入力してください。")
            }
            if(isbn.length != 13){
                return alert("ISBNは13桁で入力してください。")
            }

            // アクセス開始
            const url  = `https://api.openbd.jp/v1/get?isbn=${isbn}`

            $.getJSON(url, (reply) => {

                // アラートなし(CodeReaderの精度が△)
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

                // モーダルを閉じる
                this.modal_camera = false

                console.log("最終データ：", this.book)
            })
        }
    }
}
</script>
