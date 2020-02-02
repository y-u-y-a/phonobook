// パッケージ
import Vue from "vue"
import VueRouter from "vue-router"


import Home from "./pages/Home"
// Admin関係
import AdminTop from "./pages/admin/Top"
import AdminUser from "./pages/admin/User"
import AdminBook from "./pages/admin/Book"
import AdminBookEdit from "./pages/admin/Edit"
// User関係
import UserTop from "./pages/user/Top"
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
  { path: "/home", component: Home },

  // admin関連
  { path: "/admin/top", component: AdminTop },
  { path: "/admin/user", component: AdminUser },
  { path: "/admin/book", component: AdminBook },
  { path: "/admin/edit", component: AdminBookEdit },

  // user関連
  { path: "/user/top", component: UserTop },
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
