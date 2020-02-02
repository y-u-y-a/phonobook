
import Vue  from "vue"
import Vuex from "vuex"
// auth.jsの読み込み
import Auth from "./auth"

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    Auth
  }
})

export default store
