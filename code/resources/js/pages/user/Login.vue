<template>
  <div class="row flex-x-center">
    <div class="col-md-8 bg-white shadow">
      <header class="p-2 font-24 b-solid-silver-1">ログインする</header>
      <div class="p-2">
        <div v-if="error" class="p-05 mb-1 font-18 bg-accent-half">{{ error }}</div>
        <FormInput v-model="email" label="メールアドレス" placeholder="例：xxxxx@gmail.com" />
        <FormInput v-model="password" label="パスワード" placeholder="8ケタ以上" />
        <FormButton
          @trigger=" auth()"
          button_name="ログイン"
        />
      </div>
    </div>
  </div>
</template>

<script>
import FormInput from "@/components/form/Input.vue";
import FormButton from "@/components/form/Button.vue";

import { mapState, mapGetters, mapActions } from "vuex";

export default {
  components: {
    FormInput,
    FormButton
  },

  data() {
    return {
      email: "",
      password: "",
      error: ""
    };
  },

  methods: {
    ...mapActions("User", ["login"]),

    async auth() {
        let result = await this.login({email: this.email, password: this.password});

        if(!result) {
            this.error = "入力内容を確認してください。";
        }
    }
  }
};
</script>
