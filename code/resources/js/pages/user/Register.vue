<template>
    <div class="wm-60 bg-white">
        <header class="p-2 font-24 b-solid-silver-1">ユーザーを登録する</header>
        <div class="p-2">
            <div class="form-group">
                <label class="mb-05">部署</label>
                <FormSelect
                    slot="form-select"
                    :options="[
                        {name: '営業部', value: ''},
                        {name: 'システム部', value: ''},
                        {name: '経理部', value: ''}
                    ]" />
            </div>
            <div class="form-group">
                <label class="mb-05">名前</label>
                <input v-model="name" class="form-control" type="text" >
            </div>
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
            <div class="form-group">
                <label class="mb-05">パスワード確認</label>
                <input v-model="password_confirmation" class="form-control" type="text" >
            </div>
            <button
                @click="register({
                    name: name,
                    email: user_name + domain,
                    password: password,
                    password_confirmation: password_confirmation
                })"
                class="btn c-white bg-main"
                type="submit">
                新規登録する
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
