<template>
  <div id="adminUser">
    <div class="adminUser-wrapper">
      <form class="form" @submit.prevent="registerUser">
        <p>ユーザーを登録する</p>
        <div class="form-wrapper">
          <input type="hidden" name="_token" :value="csrf" />
          <div class="name form-input">
            <label>名前 ：</label>
            <input v-model="name" type="text" placeholder="名前" required />
          </div>
          <div class="email form-input">
            <label>メールアドレス：</label>
            <input v-model="email" type="text" placeholder="メールアドレス" required />
          </div>
          <div class="password form-input">
            <label>パスワード ：</label>
            <input v-model="password" type="password" placeholder="パスワード" required />
          </div>
          <div class="password_confirmation form-input">
            <label>パスワード確認：</label>
            <input v-model="password_confirmation" type="password" placeholder="確認用" required />
          </div>
          <div class="registerButton">
            <button type="submit">新規登録する</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      csrf: document
        .querySelector("meta[name='csrf-token']")
        .getAttribute("content"),
      name: "",
      email: "",
      password: "",
      password_confirmation: ""
    };
  },
  methods: {
    // async="非同期"
    async registerUser() {
      var params = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      };
      // dispatchでAuthストアモジュールのresigterアクションを呼出す
      // await="待つ"
      await this.$store
        .dispatch("Auth/register", params)
        .then(response => {
          alert("登録が完了しました");
          this.$router.push("/");
        })
        .catch(error => {
          console.log(error.name + ": " + error.message);
          alert("失敗しました");
        });
    }
  }
};
</script>


<style lang="scss" scoped>
$white: white;

// PC
@media screen and (min-width: 640px) {
  #adminUser {
    width: 40%;
    margin: 0 auto;
    .adminUser-wrapper {
      // 余白作り
      margin-top: 50px;
      background-color: $white;
    }
  }
}
</style>
