// パッケージ
import Vue from "vue"
import VueRouter from "vue-router"


import Home from "./pages/Home"
// Admin関係
import AdminUser from "./pages/admin/User"
import AdminBook from "./pages/admin/Book"
import AdminBookEdit from "./pages/admin/Edit"
// User関係
import UserLogin from "./pages/user/Login"
import UserArrival from "./pages/user/Arrival"
import UserShow from "./pages/user/Show"
// Book関係
import BookIndex from "./pages/book/Index"
import BookBorrow from "./pages/book/Borrow"
import BookShow from "./pages/book/Show"


// VueRouterプラグインを使用→これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

const routes = [
  { path: "/", component: Home },
  { path: "/Home", component: Home },

  // admin関連
  { path: "/user/register", component: AdminUser },
  { path: "/book/new", component: AdminBook },
  { path: "/book/edit", component: AdminBookEdit },

  // user関連
  { path: "/user/login", component: UserLogin },
  { path: "/user/show/:id", component: UserShow },
  { path: "/user/arrival", component: UserArrival },

  // book関連
  { path: "/book/index", component: BookIndex },
  { path: "/book/borrow", component: BookBorrow },
  { path: "/book/show/:id", component: BookShow },
]

// VueRouterインスタンスを作成
const router = new VueRouter({
  mode: "history", //パスに#が付かなくなる
  routes
})

// VueRouterインスタンスをエクスポート
export default router
