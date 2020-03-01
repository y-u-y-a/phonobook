
const state = {
    is_admin: false,
    login_user: null,
    all_users: []
}

// stateの直接参照は非推奨なのでgettersに定義してコール
const getters = {
}

// commit("呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期のみ)
const mutations = {

    setAllUsers(state, users){
        state.all_users = users
    },

    setLoginUser(state, user){
        state.login_user = user
    },

    unsetLoginUsr(state){
        state.login_user = null
    },

    switch_admin(state){
        state.is_admin = !state.is_admin
    }
}

// dispatch("モジュール名/呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期/非同期)
const actions = {

    async getAllUsers(context) {

        await axios.get("/api/users/all")
        .then((response) => {
            // 出勤状態を記号に変換
            var users = response.data
            // 表示には◯×を使用
            users.forEach((user) => {
                if (user.state == 0) {
                    user.state = "×"
                }else{
                    user.state = "◯"
                }
            })
            context.commit("setAllUsers", users)
        })
    },

    async getLoginUser(context) {

        await axios.get("/api/users/logined")
        .then((response) => {
            context.commit("setLoginUser", response.data)
        })
    },

    async register(context, params) {

        await axios.post("/api/auth/register", params)
        .then((response) => {
            console.log(response.data)
            alert("登録が完了しました")
            location.href = "/"
        })
        .catch((error) => {
            console.log(error.name + ": " + error.message)
            alert("登録に失敗しました")
        })
    },

    async login(context, params){

        await axios.post("/api/login", params)
        .then((response) => {
            context.commit("setLoginUser", response.data)
            return
        })
    },

    async logout(context){
        await axios.post("/api/logout")
        context.commit("unsetLoginUser")
        return
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
