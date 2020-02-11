<template>
    <div id="register">
        <form @submit.prevent="register"><!-- 送信時のリロードをキャンセル -->
            <div class="title">ユーザーを登録する</div>
            <div class="form-container">
                <!-- 子へバインディングされた空の値を渡す -->
                <!-- signalEventを検知する度にgetValueを実行 -->
                <FormInput @signalEvent="getName" label="名前" placeholder="8文字以上" ></FormInput>
                <FormInput @signalEvent="getEmail" label="メールアドレス" placeholder="" ></FormInput>
                <FormInput @signalEvent="getPass" label="パスワード" placeholder="8文字以上の半角英数字" ></FormInput>
                <FormInput @signalEvent="getPassConf" label="パスワード確認" placeholder="8文字以上の半角英数字" ></FormInput>
            </div>
            <FormButton button_name="新規登録する"></FormButton>
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
            name: null,
            email: null,
            password: null,
            password_confirmation: null
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
            .then(response => {
                alert("登録が完了しました")
                this.$router.push("/")
            })
            .catch(error => {
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
