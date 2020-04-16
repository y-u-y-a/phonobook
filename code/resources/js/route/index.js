// パッケージ
import Vue from "vue"
import VueRouter from "vue-router"


import Home from "../pages/Home"
// User関係
import UserRegister from "../pages/user/Register"
import UserLogin from "../pages/user/Login"
import UserArrival from "../pages/user/Arrival"
import UserShow from "../pages/user/Show"
// Book関係
import BookNew from "../pages/book/New"
import BookEdit from "../pages/book/Edit"
import BookIndex from "../pages/book/Index"
import BookBorrow from "../pages/book/Borrow"
import BookShow from "../pages/book/Show"


// VueRouterプラグインを使用→これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// ページ遷移URL一覧
const routes = [
  { path: "/", component: Home },

  // user関連
  { path: "/user/Register", component: UserRegister },
  { path: "/user/Login", component: UserLogin },
  { path: "/user/Show/:id", component: UserShow },
  { path: "/user/Arrival", component: UserArrival },

  // book関連
  { path: "/book/New", component: BookNew },
  { path: "/book/Edit", component: BookEdit },
  { path: "/book/Index", component: BookIndex },
  { path: "/book/Borrow", component: BookBorrow },
  { path: "/book/Show/:id", component: BookShow },
]

export default new VueRouter({
  mode: "history", //パスに#が付かなくなる
  routes
})
