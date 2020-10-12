/* < bladeのscriptで読み込まれるファイル > */

import Vue from "vue"

import App from "./App.vue"
import "./bootstrap.js"
import Router from "./route/index.js"
import Store from "./store/index.js"


const createApp = async function () {

  // SSRごとにログインユーザーを取得
  await Store.dispatch("User/getLoginUser")

  new Vue({
    el: "#app",
    router: Router,
    store: Store,
    render: h => h(App),
  })
}
createApp()
