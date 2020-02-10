<template>
    <div>
        <div class="half-box">
            <Camera></Camera>
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
                        <tr v-for="n in 50">
                            <td>{{ n }}</td>
                            <td>ジョンソン</td>
                            <td>12:22</td>
                            <td>◯</td>
                        </tr>
                    </tbody>
                    <!-- <tr v-for="user in users" :id="user.id">
                        <td>{{user.name}}</td>
                        <td>{{user.updated_at}}</td>
                        <td>{{user.state}}</td>
                    </tr> -->
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import Camera    from "../../components/Camera.vue"
import FormButton from "../../components/form/Button.vue"

export default {
    components: {
        Camera,
        FormButton
    },

    data() {
        return {
            users: []
        };
    },

    created() {
        this.getAllUsers();
    },

    methods: {
        // 全てのユーザー取得
        getAllUsers() {
            var axios = require("axios");
            axios.get("/api/users/all")
                .then(response => {
                    // 出勤状態を記号に変換
                    this.users = response.data;
                    for (var i = 0; i < this.users.length; i++) {
                        var user = this.users[i];
                        if (user.state == 0) {
                            user.state = "×";
                        } else {
                            user.state = "◯";
                        }
                    }
                })
                // 失敗した場合
                .catch(error => {
                    console.log(error.name + ": " + error.message);
                });
        },

        // 出退勤処理と表示データの更新
        changeState(user) {
            var params = {
                user_id: user.id
            };
            // 出退勤処理
            var axios = require("axios");
            axios.post("/api/users/state", params)
                .then(response => {
                    // 表示データの更新
                    this.getAllUsers();
                    var element = document.getElementById(user.id);
                    element.style.backgroundColor = "#F6CECE";
                    element.scrollIntoView({
                        behavor: "smooth"
                    });
                })
                .catch(error => {
                    console.log(error.name + ": " + error.message);
                });
        }
    }
};
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
</style>
