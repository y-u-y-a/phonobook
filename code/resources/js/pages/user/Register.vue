<template>
    <div id="register">
        <form @submit.prevent="register">
            <div class="title">ユーザーを登録する</div>
            <div class="form-container">
                <input type="hidden" name="_token" :value="csrf" />
                <FormInput label="名前" placeholder="8文字以上" ></FormInput>
                <FormInput label="メールアドレス" placeholder="" ></FormInput>
                <FormInput label="パスワード" placeholder="8文字以上の半角英数字" ></FormInput>
                <FormInput label="パスワード確認" placeholder="8文字以上の半角英数字" ></FormInput>
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
            csrf: document
                .querySelector("meta[name='csrf-token']")
                .getAttribute("content"),
            name: "",
            email: "",
            password: "",
            password_confirmation: ""
        };
    },
    methods: {
        // async="非同期"
        async register() {
            var params = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            };
            // dispatchでAuthストアモジュールのresigterアクションを呼出す
            // await="待つ"
            await this.$store
                .dispatch("Auth/register", params)
                .then(response => {
                    alert("登録が完了しました");
                    this.$router.push("/");
                })
                .catch(error => {
                    console.log(error.name + ": " + error.message);
                    alert("失敗しました");
                });
        }
    }
};
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
