<template>
  <div class="row flex-x-center">
    <div class="col-md-8 bg-white shadow">
      <header class="p-2 font-24 b-solid-silver-1">ユーザーを登録する</header>
      <div class="p-2">
        <FormSelect
          label="部署"
          :options="[
            {name: '営業部', value: ''},
            {name: 'システム部', value: ''},
            {name: '経理部', value: ''}
          ]" />
        <FormInput v-model="name" label="名前" placeholder="" />
        <FormInput v-model="email" label="メールアドレス" placeholder="" />
        <FormInput v-model="password" label="パスワード" placeholder="" />
        <FormInput v-model="password_confirmation" label="パスワード確認" placeholder="" />

        <FormButton
          @trigger="register({
            name: name,
            email: email,
            password: password,
            password_confirmation: password_confirmation
          })"
          button_name="新規登録" />
      </div>
    </div>
  </div>
</template>

<script>
import FormInput from "../../components/form/Input.vue";
import FormSelect from "../../components/form/Select.vue";
import FormButton from "../../components/form/Button.vue";

import { mapState, mapGetters, mapActions } from "vuex";

export default {
  components: {
    FormInput,
    FormSelect,
    FormButton
  },

  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: ""
    };
  },

  methods: {
    ...mapActions("User", ["register"])
  }
};
</script>
