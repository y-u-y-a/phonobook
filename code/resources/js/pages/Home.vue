<template>
    <div>
        <!-- <ul class="button-list">
            <UserButton button_name="出勤する or 退勤する" path="/user/Arrival" />
            <UserButton button_name="本を借りる" path="/book/Borrow" />
            <UserButton button_name="本の一覧をみる" path="/book/Index" />
            <template v-if="user_id == undefined">
                <UserButton button_name="ログインする" path="/user/Login" />
            </template>
            <template v-else-if="user_id != undefined">
                <UserButton button_name="マイページ" :path="'/user/Show/' + user_id" />
            </template>
        </ul> -->
        <ul class="button-list">
            <AdminButton button_name="ユーザーを登録する" path="/user/Register" />
            <AdminButton button_name="本を登録する" path="/book/New" />
            <AdminButton button_name="本を更新・削除する" path="/book/Edit" />
        </ul>
    </div>
</template>


<script>

import UserButton from "../components/top/UserButton"
import AdminButton from "../components/top/AdminButton"

export default {
    components: {
        UserButton,
        AdminButton
    },

    data() {
        return {
            user_id: ""
        }
    },

    created() {
        this.getLoginUser()
    },

    methods: {
        async getLoginUser() {

            await this.$axios.get("/api/users/logined")
                .then(response => {
                    this.user_id = response.data.id
                })
                .catch(error => {
                    console.log(error.name + ": " + error.message)
                })
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
