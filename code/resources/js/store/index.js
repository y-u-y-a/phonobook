
import Vue  from "vue"
import Vuex from "vuex"

import User from "./user.js"
import Book from "./book.js"

Vue.use(Vuex)

const store = new Vuex.Store({

  // mapStateで呼出すnamespaceに対応
  modules: {
    User,
    Book
  }
})

export default store
