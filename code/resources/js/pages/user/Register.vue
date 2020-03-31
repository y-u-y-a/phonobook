<template>
    <div class="wm-50 my-2">
        <div class="pb-2 bg-white">
            <div class="title py-2 b-font-20 text-center">ユーザーを登録する</div>
            <div class="wm-90 pt-2">
                <FormInput
                    v-model="name"
                    label="名前"
                    placeholder="" />
                <FormInput
                    v-model="user_name"
                    label="メールアドレス"
                    placeholder="">
                    <FormSelect
                        slot="form-select"
                        :options="[
                        {name: '@gmail.com', value: '@gmail.com'},
                        {name: '@yahoo.co.jp', value: '@yahoo.co.jp'}
                        ]"
                        default_value="@yahoo.co.jp"
                        v-model="domain" />
                </FormInput>
                <FormInput
                    v-model="password"
                    label="パスワード"
                    placeholder="" />
                <FormInput
                    v-model="password_confirmation"
                    label="パスワード確認"
                    placeholder="" />
            </div>
            <div class="text-center">
                <FormButton
                    @signalEvent="register({
                        name: name,
                        email: user_name + domain,
                        password: password,
                        password_confirmation: password_confirmation
                    })"
                    button_name="新規登録する" />
            </div>
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
            name: "taku",
            user_name: "taku",
            domain: "@yahoo.co.jp",
            password: "takutaku",
            password_confirmation: "takutaku"
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
    .title{
        letter-spacing: 2px;
        border-bottom: 1px solid $silver;
    }
}
</style>
