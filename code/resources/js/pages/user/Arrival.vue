<template>
    <div>
        <div class="half-box">
            <Camera @signalEvent="changeState" />
        </div>

        <div class="half-box">
            <div id="officers">
                <table>
                    <thead>
                        <tr>
                            <th>社員番号</th>
                            <th>名前</th>
                            <th>出勤時間</th>
                            <th>出勤状況</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in all_users"
                            :key="index"
                            :id="user.id"
                        >
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.updated_at }}</td>
                            <td>{{ user.state }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import Camera from "../../components/Camera.vue"
import FormButton from "../../components/form/Button.vue"

import { mapState, mapGetters, mapActions } from "vuex"

export default {

    components: {
        Camera,
        FormButton
    },

    created() {
        this.getAllUsers()
    },

    computed: {
        ...mapState("User", ["all_users"]),
    },

    methods: {
        ...mapActions("User", ["getAllUsers"]),

        // 出退勤処理と表示データの更新
        async changeState(user) {

            console.log(user)
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
        }
    }
}
</script>


<style lang="scss" scoped>

@import "../../../sass/app.scss";

// PC
@media screen and (min-width: 640px) {
    #officers{
        max-height: calc(100vh - 84px);
        overflow: auto;
        text-align: center;
        background-color: $white;
        table{
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 2px;
        }
        tr,th,td {
            border: 1px solid $silver;
        }
        th {
            font-size: 18px;
            font-weight: bold;
            background-color: $light-blue;
        }
        th, td{
            padding: 1rem 0;
        }
    }
}
.switch-alert{
    background-color: #F6CECE;
}
</style>
