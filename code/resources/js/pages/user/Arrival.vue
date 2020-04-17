<template>
  <div class="row flex-x-center font-18">
    <div class="col-md-10">
      <FormRichButton
        @trigger="modal_camera=true"
        button_name="カメラ起動"
        class="my-2" />

      <table class="d-block bg-white text-center shadow">
        <tr id="thead" class="row py-1 b-solid-silver-4 bg-white">
          <th class="col-md-3 col-4 dot">社員番号</th>
          <th class="col-md-3 col-4 dot">名前</th>
          <th class="pc col-md-3 dot">出勤時間</th>
          <th class="col-md-3 col-4 dot">出勤状況</th>
        </tr>
        <tr
          v-for="user in all_users"
          :key="user.name"
          :id="user.id"
          class="row py-1 b-dashed-silver-1"
        >
          <td class="col-md-3 col-4 dot">{{ user.id }}</td>
          <td class="col-md-3 col-4 dot">{{ user.name }}</td>
          <td class="pc col-md-3 dot">{{ user.updated_at }}</td>
          <td class="col-md-3 col-4 dot">{{ user.state }}</td>
        </tr>
      </table>
    </div>

    <ModalCamera
      v-if="modal_camera"
      @trigger="modal_camera=false"
      @authTrigger="changeState"
      camera_type="capture" />
  </div>
</template>

<script>
import ModalCamera from "../../modal/Camera.vue";
import FormRichButton from "../../components/form/RichButton.vue";

import { mapState, mapGetters, mapActions } from "vuex";

export default {
  components: {
    ModalCamera,
    FormRichButton
  },

  created() {
    this.getAllUsers();
  },

  data() {
    return {
      modal_camera: false
    };
  },

  computed: {
    ...mapState("User", ["all_users"])
  },

  methods: {
    ...mapActions("User", ["getAllUsers"]),

    // 出退勤処理と表示データの更新
    async changeState(user) {
      var params = {
        user_id: user.id
      };
      // state切替
      await axios.post("/api/users/state", params)
      .then(response => {
        // 表示内容の切替のため
        this.getAllUsers();
      });
      // ハイライト
      var el = document.getElementById(user.id);
      el.classList.add("bg-main-half");
      el.scrollIntoView({
        behavor: "smooth"
      });

      // モーダルを閉じる
      this.modal_camera = false;
    }
  }
};
</script>


<style lang="scss" scoped>
@import "../../../sass/app.scss";

#thead {
  z-index: 999;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
</style>
