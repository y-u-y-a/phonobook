<template>
  <div id="home" class="row flex-x-center flex-y-center">
    <div class="flex-column col-md-4">
      <!-- 全てのユーザー -->
      <TopButton
        v-for="button in user_button_list"
        :key="button.name"
        :button_name="button.name"
        :path="button.path"
        class="mx-2 my-2 c-main solid-main-1"
      />
    </div>
    <!-- 管理ユーザーのみ -->
    <div v-if="is_admin" class="flex-column col-md-4">
      <TopButton
        v-for="button in admin_button_list"
        :key="button.name"
        :button_name="button.name"
        :path="button.path"
        class="mx-2 my-2 c-accent solid-accent-1"
      />
    </div>
  </div>
</template>


<script>
import TopButton from "@/components/top/Button";

import { mapState, mapGetters, mapActions } from "vuex";

export default {
  components: {
    TopButton
  },

  data() {
    return {
      user_button_list: [
        { name: "出勤する or 退勤する", path: "/user/Arrival" },
        { name: "本を借りる", path: "/book/Borrow" },
        { name: "本の一覧をみる", path: "/book/Index" }
      ],
      admin_button_list: [
        { name: "ユーザーを登録する", path: "/user/Register" },
        { name: "本を登録する", path: "/book/New" },
        { name: "本を更新・削除する", path: "/book/Edit" }
      ]
    };
  },

  computed: {
    ...mapState("User", ["login_user", "is_admin"])
  },

  created() {
    console.log("ログイン：", this.login_user);
  }
};
</script>


<style lang="scss" scoped>
#home {
  height: calc(100vh - 66px);
}
</style>
