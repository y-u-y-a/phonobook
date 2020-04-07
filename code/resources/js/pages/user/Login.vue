<template>
    <div class="row flex-x-center mt-2">
        <div class="col-md-5 bg-white">
            <div class="py-2 b-font-20 letter-2 text-center b-solid-silver-1">ログインする</div>
            <div class="wm-90 py-2">
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

                <div class="text-center">
                    <FormButton
                        @signalEvent="login({
                            email: user_name + domain,
                            password: password
                        })"
                        button_name="ログインする" />
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
    .title{
        letter-spacing: 2px;
        border-bottom: 1px solid $silver;
    }
}
</style>
