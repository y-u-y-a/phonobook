<template>
    <div id="register">
        <div class="form">
            <div class="title">ユーザーを登録する</div>
            <div class="form-container">
                <FormInput v-model="name" label="名前" placeholder="" />
                <FormInput v-model="email" label="メールアドレス" placeholder="" />
                <FormInput v-model="password" label="パスワード" placeholder="" />
                <FormInput v-model="password_confirmation" label="パスワード確認" placeholder="" />
            </div>
            <FormButton @signalEvent="register({
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation
                })" button_name="新規登録する" />
        </div>
    </div>
</template>

<script>

import FormInput from "../../components/form/Input.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

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
        ...mapActions("User", ["register"])
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
    .form{
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
