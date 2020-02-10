// csrfが送信される？
import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../../util.js"

// CSR内でのデータの状態管理
const state = {
    login_user: ''
}

// stateの直接参照は非推奨なのでgettersに定義してコール
const getters = {
}

// commit("呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期のみ)
const mutations = {
    set(state, user){
        state.login_user = user
    }
}

// dispatch("モジュール名/呼出す関数名", 引数1, ...)：データを操作する関数を管理(同期/非同期)
const actions = {

    async getLoginUser(context) {
        await axios.get("/api/users/logined")
        .then(response => {
            context.commit("set", response.data)
        })
    },

    async register(params) {
        await axios.post("/api/auth/register", params)
        .then(response => {
        })
        .catch(err => {
            console.log(err.name + ": " + err.message)
        })
    },

    async login(context, params){
        await axios.post("/api/login", params)
        .then(response => {
            context.commit("set", response.data)
        })
        .catch(err => {
            console.log(err.name + ": " + err.message)
        })
    },

    async logout(context){
        await axios.post("/api/logout")
        context.commit("set", '')
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
