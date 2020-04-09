<template>
    <div class="row flex-x-center mt-6 flex-y-center">
        <div class="d-inline-block flex-column col-md-4 col-12">
            <!-- 全てのユーザー -->
            <TopButton
                id="top-button"
                v-for="button in user_button_list"
                :key="button.name"
                :button_name="button.name"
                :path="button.path"
                class="top-button mx-2 c-main bg-white solid-main-1 radius-4 shadow" />
        </div>
        <!-- 管理ユーザーのみ -->
        <div v-if="is_admin" class="flex-column col-md-4 col-12">
            <TopButton
                v-for="button in admin_button_list"
                :key="button.name"
                :button_name="button.name"
                :path="button.path"
                class="admin-button mx-2 c-accent bg-white solid-accent-1 radius-4 shadow" />
        </div>
    </div>
</template>


<script>

import TopButton from "../components/top/Button"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        TopButton
    },

    data(){
        return{
            user_button_list: [
                {name: "出勤する or 退勤する", path: "/user/Arrival"},
                {name: "本を借りる", path: "/book/Borrow"},
                {name: "本の一覧をみる", path: "/book/Index"}
            ],
            admin_button_list: [
                {name: "ユーザーを登録する", path: "/user/Register"},
                {name: "本を登録する", path: "/book/New"},
                {name: "本を更新・削除する", path: "/book/Edit"}
            ]
        }
    },

    computed: {
        ...mapState("User", ["login_user", "is_admin"]),
    },

    created(){
        console.log("ログイン：", this.login_user)
    }
}
</script>


<style lang="scss" scoped>

@import "../../sass/app.scss";

.top-button:hover{
    color: $white;
    background: $main;
}
.admin-button:hover{
    color: $white;
    background: $accent;
}

</style>
