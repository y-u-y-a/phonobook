/* < bladeのscriptで読み込まれるファイル > */

import Vue from "vue"

import App from "./App.vue"
import "./bootstrap.js"
import router from "./router.js"
import store from "./store/index.js"

const createApp = async () => {
    // SSRごとにログインユーザーの取得を行う
    await store.dispatch("User/getLoginUser")

    new Vue({
        router,
        store,
        render: h => h(App),
    }).$mount("#app")
}
createApp()

// new Vue({
//     router,
//     store,
//     render: h => h(App),
// }).$mount("#app")

// new Vue({
//     router,
//     store,
//     el: "#app",
//     components: {App}, template: "<App/>"
// })
