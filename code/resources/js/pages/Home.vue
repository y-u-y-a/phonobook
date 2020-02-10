<template>
    <div>
        <ul v-if="!is_active" class="button-list">
            <button @click="is_active=!is_active" button_name="切り替え" ></button>
            <UserButton button_name="出勤する or 退勤する" path="/user/Arrival" />
            <UserButton button_name="本を借りる" path="/book/Borrow" />
            <UserButton button_name="本の一覧をみる" path="/book/Index" />
            <template v-if="login_user === ''">
                <UserButton button_name="ログインする" path="/user/Login" />
            </template>
            <template v-else>
                <UserButton button_name="マイページ" :path="'/user/Show/'+login_user.id" />
            </template>
        </ul>
        <ul v-else class="button-list">
            <button @click="is_active=!is_active" button_name="切り替え" ></button>
            <AdminButton button_name="ユーザーを登録する" path="/user/Register" />
            <AdminButton button_name="本を登録する" path="/book/New" />
            <AdminButton button_name="本を更新・削除する" path="/book/Edit" />
        </ul>
    </div>
</template>


<script>

import UserButton from "../components/top/UserButton"
import AdminButton from "../components/top/AdminButton"

import { mapState, mapGetters, mapActions } from "vuex"

export default {
    components: {
        UserButton,
        AdminButton
    },

    computed: {
        // スプレッド演算子(this.$store.stateの代替)
        ...mapState("User", ["login_user"]),
    },

    data() {
        return {
            is_active: false,
        }
    }
}
</script>


<style lang="scss" scoped>

// PC
@media screen and (min-width: 640px) {
    .button-list {
        width: 40%;
        margin: 0 auto;
        padding-top: 100px;
    }
}
</style>
