<template>
    <div class="form-wrapper">
        <div class="form">
            <div class="title">ログインする</div>
            <div class="form-container">
                <FormInput v-model="user_name" label="メールアドレス" placeholder="" />
                <FormSelect :options="[
                    {name: '@gmail.com', value: '@gmail.com'},
                    {name: '@yahoo.co.jp', value: '@yahoo.co.jp'}
                ]" default_value="@yahoo.co.jp" v-model="domain" />
                <FormInput v-model="password" label="パスワード" placeholder="" />
            </div>
            <FormButton @signalEvent="login({
                email: user_name + domain,
                password: password
            })" button_name="ログインする" />
        </div>
    </div>
</template>


<script>

import FormInput from "../../components/form/Input.vue"
import FormSelect from "../../components/form/Select.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        FormInput,
        FormSelect,
        FormButton
    },

    data() {
        return {
            user_name: "tanaka",
            domain: "@gmail.com",
            password: "tanakatanaka"
        }
    },

    methods: {
        ...mapActions("User", ["login"])
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";
// PC
@media screen and (min-width: 640px) {
    .form-wrapper{
        width: 50%;
        margin: 2rem auto 0;
    }
    .form{
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
