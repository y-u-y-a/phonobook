<template>
    <div class="wm-40 pt-5">
        <!-- 管理ユーザー -->
        <div v-if="is_admin" id="admin-actions">
            <TopButton
                button_name="ユーザーを登録する"
                path="/user/Register" />
            <TopButton
                button_name="本を登録する"
                path="/book/New" />
            <TopButton
                button_name="本を更新・削除する"
                path="/book/Edit" />
        </div>
        <!-- 一般ユーザー -->
        <div v-else-if="!is_admin" id="user-actions">
            <TopButton
                button_name="出勤する or 退勤する"
                path="/user/Arrival" />
            <TopButton
                button_name="本を借りる"
                path="/book/Borrow" />
            <TopButton
                button_name="本の一覧をみる"
                path="/book/Index" />
            <TopButton
                v-if="login_user == ''"
                button_name="ログインする"
                path="/user/Login" />
            <TopButton
                v-else
                button_name="マイページ"
                :path="'/user/Show/'+login_user.id" />
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

// PC
@media screen and (min-width: 640px) {

    #user-actions{
        button {
            color: $main;
            border: 1px solid $main;
        }
        button:hover{
            color: $white;
            background: $main;
        }
    }
    #admin-actions{
        button {
            color: $accent;
            border: 1px solid $accent;
        }
        button:hover{
            color: $white;
            background: $accent;
        }
    }
}
</style>
