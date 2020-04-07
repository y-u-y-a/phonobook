<template>
    <div class="wm-90 font-18">

        <div class="row my-2">
            <FormButton
                @signalEvent="modal_camera=!modal_camera"
                button_name="カメラ起動" />
        </div>

        <table class="d-block bg-white text-center shadow">
            <tr class="row py-1 b-solid-silver-1">
                <th class="col-md-3 col-4 dot">社員番号</th>
                <th class="col-md-3 col-4 dot">名前</th>
                <th class="pc col-md-3 dot">出勤時間</th>
                <th class="col-md-3 col-4 dot">出勤状況</th>
            </tr>
            <tr v-for="user in all_users"
                :key="user.id"
                :id="user.id"
                class="row py-1 b-dashed-silver-1">
                <td class="col-md-3 col-4 dot">{{ user.id }}</td>
                <td class="col-md-3 col-4 dot">{{ user.name }}</td>
                <td class="pc col-md-3 dot">{{ user.updated_at }}</td>
                <td class="col-md-3 col-4 dot">{{ user.state }}</td>
            </tr>
        </table>

        <ModalCamera
            v-if="modal_camera"
            @authTrigger="changeState"
            camera_type="capture" />
    </div>
</template>

<script>

import ModalCamera from "../../modal/Camera.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        ModalCamera,
        FormButton
    },

    created() {
        this.getAllUsers()
    },

    data(){
        return {
            modal_camera: false
        }
    },

    computed: {
        ...mapState("User", ["all_users"]),
    },

    methods: {
        ...mapActions("User", ["getAllUsers"]),

        // 出退勤処理と表示データの更新
        async changeState(user) {

            var params = {
                user_id: user.id
            }
            // state切替
            await axios.post("/api/users/state", params)
            .then((response) => {
                // 表示内容の切替のため
                this.getAllUsers()
            })
            // ハイライト
            var el = document.getElementById(user.id)
            el.classList.add("switch-alert")
            el.scrollIntoView({
                behavor: "smooth"
            })

            // モーダルを閉じる
            this.modal_camera = !this.modal_camera
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {
}
.switch-alert{
    background: $main-half;
}
</style>
