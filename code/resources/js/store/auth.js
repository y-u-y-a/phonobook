// csrfが送信される？
import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util"

// データの保存場所
const state = {
  user: null
}

// データの算出(ユーザーがログイン中であるかを表現できる)
const getters = {
}

// storeのstateを変更する唯一の手段(同期的)(commitで呼び出す)
const mutations = {
  // (ステート、新データ)
  setUser(state, user) {
    state.user = user
  }
}

// (非同期的)(dispatch("Auth/register", params)で呼び出す)
const actions = {

  async register(context, params) {
    const response = await axios.post("/api/auth/register", params); // axiosで動かす
    context.commit("setUser", response.params);// stateに保存
    return response.params; // この関数の戻り値
  },

  async login(context, params){
    const response = await axios.post("/api/login", params); // axiosで動かす
    context.commit("setUser", response.params); // stateに保存
    return response.params; // この関数の戻り値
  },

  async logout(context){
    const response = await axios.post("/api/logout"); // axiosで動かす
    context.commit("setUser", null); // stateをnullにする
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
