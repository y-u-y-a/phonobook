
import Vue  from "vue"
import Vuex from "vuex"

import User from "./user.js"
import Book from "./book.js"

Vue.use(Vuex)

export default new Vuex.Store({

  // mapStateで呼出すnamespaceに対応
  modules: {
    User,
    Book
  }
})
