
const state = {
  is_admin: true,
  login_user: null,
  all_users: [],
//   error: {
//     email: "入力内容を確認してください。",
//     password: "入力内容を確認してください。"
//   }
}

const getters = {
}

// データを操作する関数を管理(同期のみ)
const mutations = {

  setAllUsers(state, users) {
    state.all_users = users
  },

  setLoginUser(state, user) {
    state.login_user = user
  },

  unsetLoginUsr(state) {
    state.login_user = null
  },

  switch_admin(state) {
    state.is_admin = !state.is_admin
  }
}

// データを操作する関数を管理(同期/非同期)
const actions = {

  async getAllUsers({commit}) {

    await axios.get("/api/users/all")
      .then((response) => {
        // 出勤状態を記号に変換
        let users = response.data

        users.forEach((user) => {

          if (user.state == 0) {
            user.state = "×"
          } else {
            user.state = "◯"
          }
        })
        commit("setAllUsers", users)
      })
  },

  async getLoginUser({commit}) {

    await axios.get("/api/users/logined")
      .then((response) => {

        let get_user = response.data

        if (get_user) {
          commit("setLoginUser", get_user)
        }
      })
  },

  async register(context, { name, email, password, password_confirmation }) {

    let params = {
      name: name,
      email: email,
      password: password,
      password_confirmation: password_confirmation
    }

    await axios.post("/api/auth/register", params)
      .then((response) => {
        console.log(response.data)
        location.href = "/"
      })
  },

  async login({commit}, { email, password }) {

    let params = {
      email: email,
      password: password
    };

    await axios.post("/api/login", params)
    .then((res) => {
        commit("setLoginUser", res.data);
        location.href = "/";
    })
    .catch((err) => {
        console.log(err);
        return false;
    })
    // // エラー処理
    // if(result.errors) {

    //     let get_err = res.errors;
    //     if(get_err.email) {
    //         this.error.email = get_err.email[0];
    //     }
    //     if(get_err.password) {
    //         this.error.password = get_err.password[0];
    //     }
    //     return;
    // }
  },

  async logout({commit}) {
    await axios.post("/api/logout")
      .then(() => {
        commit("unsetLoginUser")
        location.href = "/"
      })
  }
}

export default {
  namespaced: true,
  state: state,
  getters: getters,
  mutations: mutations,
  actions: actions
}
