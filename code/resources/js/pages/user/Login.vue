<template>
    <div class="row flex-x-center">
        <div class="col-md-8 bg-white shadow">
            <header class="p-2 font-24 b-solid-silver-1">ログインする</header>
            <div class="p-2">
                <FormInput
                    v-model="email"
                    label="メールアドレス"
                    placeholder="" />
                <FormInput
                    v-model="password"
                    label="パスワード"
                    placeholder="" />
                <FormButton
                    @trigger="login({
                        email: email,
                        password: password,
                    })"
                    button_name="ログイン" />
            </div>
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
            email: "",
            password: "",
        }
    },

    methods: {
        ...mapActions("User", ["login"])
    }
}
</script>
