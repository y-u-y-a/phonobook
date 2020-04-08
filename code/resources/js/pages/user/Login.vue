<template>
    <div class="wm-60 bg-white">
        <header class="p-2 font-24 b-solid-silver-1">ログインする</header>
        <div class="p-2">
            <div class="form-group">
                <label class="mb-05">メールアドレス</label>
                <div class="flex-left">
                    <input v-model="user_name" class="form-control col-md-6 mr-1" type="text" >
                    <FormSelect
                        slot="form-select"
                        :options="[
                            {name: '@gmail.com', value: '@gmail.com'},
                            {name: '@yahoo.co.jp', value: '@yahoo.co.jp'}
                        ]"
                        default_value="@gmail.com"
                        v-model="domain"
                        class="col-md-4" />
                </div>
            </div>
            <div class="form-group">
                <label class="mb-05">パスワード</label>
                <input v-model="password" class="form-control" type="text" >
            </div>
            <button
                @click="login({
                    email: user_name + domain,
                    password: password,
                })"
                class="btn c-white bg-main"
                type="submit">
                ログインする
            </button>
        </div>
    </div>
</template>

<script>

import FormSelect from "../../components/form/Select.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        FormSelect
    },

    data() {
        return {
            user_name: "",
            domain: "@gmail.com",
            password: "",
        }
    },

    methods: {
        ...mapActions("User", ["login"])
    }
}
</script>
