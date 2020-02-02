<template>
  <div id="userTop">
    <ul class="contents">
      <li>
        <a href="/user/arrival" title="Arrival">出勤する or 退勤する</a>
      </li>
      <li>
        <a href="/book/borrow" title="Borrow">本を借りる</a>
      </li>
      <li>
        <a href="/book/index" title="List">本の一覧を見る</a>
      </li>
      <li v-if="user_id == undefined">
        <a href="/user/login" title="Login">ログインする</a>
      </li>
      <li v-if="user_id != undefined">
        <a :href="'/user/show/' + user_id" title="Show">マイページ</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user_id: ""
    };
  },
  created() {
    this.getLoginUser();
  },
  methods: {
    getLoginUser() {
      var axios = require("axios");
      axios
        .get("/api/users/logined")
        .then(response => {
          this.user_id = response.data.id;
        })
        .catch(error => {
          console.log(error.name + ": " + error.message);
        });
    }
  }
};
</script>


<style lang="scss" scoped>
$white: white;
$link-blue: #5882fa;

// PC
@media screen and (min-width: 640px) {
  #userTop {
    li {
      border: 1px solid $link-blue;
      a {
        color: $link-blue;
      }
      a:hover {
        color: $white;
        background: $link-blue;
      }
    }
  }
  .contents {
    width: 40%;
    margin: 0 auto;
    padding-top: 100px;
    li {
      margin-bottom: 30px;
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      border-radius: 4px;
      a {
        padding: 25px;
        display: block;
      }
      a:hover {
        opacity: 0.7;
      }
    }
  }
}
</style>
