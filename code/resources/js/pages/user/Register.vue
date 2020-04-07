<template>
    <div class="row flex-x-center mt-2">
        <div class="col-md-5 bg-white">
            <header class="py-2 b-font-20 letter-2 text-center b-solid-silver-1">ユーザーを登録する</header>
            <div class="wm-90 py-2">
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
                        default_value="@gmail.com"
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
            name: "",
            user_name: "",
            domain: "@gmail.com",
            password: "",
            password_confirmation: "",
        }
    },

    methods: {
        ...mapActions("User", ["register"])
    }
}
</script>
