
import Vue  from "vue"
import Vuex from "vuex"

import User from "./user.js"
import Book from "./book.js"

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    User, // mapStateで呼出すnamespaceに対応
    Book
  }
})

export default store
