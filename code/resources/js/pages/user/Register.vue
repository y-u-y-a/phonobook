<template>
    <div id="register">
        <form @submit.prevent="register">
            <div class="title">ユーザーを登録する</div>
            <div class="form-container">
                <input type="hidden" name="_token" :value="csrf" />
                <!-- 子へバインディングされた空の値を渡す -->
                <!-- onInputを検知する度にgetValueを実行 -->
                <FormInput @onInput="getName" label="名前" placeholder="8文字以上" ></FormInput>
                <FormInput @onInput="getEmail" label="メールアドレス" placeholder="" ></FormInput>
                <FormInput @onInput="getPass" label="パスワード" placeholder="8文字以上の半角英数字" ></FormInput>
                <FormInput @onInput="getPassConf" label="パスワード確認" placeholder="8文字以上の半角英数字" ></FormInput>
                <FormButton button_name="新規登録する"></FormButton>
            </div>
        </form>
    </div>
</template>

<script>

import FormInput from "../../components/form/Input.vue"
import FormButton from "../../components/form/Button.vue"

export default {
    components: {
        FormInput,
        FormButton
    },

    data() {
        return {
            csrf: document.querySelector("meta[name='csrf-token']").getAttribute("content"),
            name: "",
            email: "",
            password: "",
            password_confirmation: ""
        }
    },

    methods: {
        getName(value){
            this.name = value
        },
        getEmail(value){
            this.email = value
        },
        getPass(value){
            this.password = value
        },
        getPassConf(value){
            this.password_confirmation = value
        },

        async register() {
            var params = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            }
            await this.$store.dispatch("User/register", params)
            .then(res => {
                alert("登録が完了しました")
                this.$router.push("/")
            })
            .catch(err => {
                console.log(err.name + ": " + err.message)
                alert("失敗しました")
            })
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {
    #register{
        width: 50%;
        margin: 0 auto;
    }
    form{
        margin: 2rem 0;
        padding-bottom: 2rem;
        background: $white;
        .title{
            padding: 2rem 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
            border-bottom: 1px solid $silver;
            text-align: center;
        }
        .form-container{
            width: 90%;
            margin: 0 auto;
            padding-top: 2rem;
        }
    }
}
</style>
