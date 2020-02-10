
import "./bootstrap"
import Vue from "vue"

import router from "./router.js"
import store from "./store/index.js"
import App from "./App.vue"

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
