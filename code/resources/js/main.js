/* < bladeのscriptで読み込まれるファイル > */

import Vue from "vue"

import App from "./App.vue"
import "./bootstrap.js"
import Router from "./router.js"
import Store from "./store/index.js"

// SSRごとにログインユーザーを取得
const createApp = async function() {
    await Store.dispatch("User/getLoginUser")

    new Vue({
        el: "#app",
        router: Router,
        store: Store,
        render: h => h(App),
    })
}
createApp()


// new Vue({
//     Router,
//     Store,
//     el: "#app",
//     components: { App }, // コンポーネントを登録
//     template: "<App />" // 呼び出し用のテンプレートを登録
// })

// render: function(createElement){
//     return createElement(App)
// }
// render: function(h){
//     return h(App)
// }
