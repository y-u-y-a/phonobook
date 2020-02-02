<template>
  <header>
    <div class="header-wrapper">
      <div class="title">
        <a href="/" title="Home">phonobook</a>
      </div>
      <nav>
        <ul>
          <li><a v-if="currentURL != HOST + '/user/top'" href="/user/top" title="UserTop">ユーザートップへ</a></li>
          <li><a v-if="currentURL != HOST + '/admin/top'" href="/admin/top" title="AdminTop">管理トップへ</a></li>
        </ul>
      </nav>
    </div>
  </header>
</template>


<script>
export default {
  data() {
    return {
      currentURL: "",
      HOST: ""
    };
  },
  created() {
    this.currentURL = location.href;
    this.HOST = location.origin;
  }
};
</script>


<style lang="scss" scoped>
$black: #2e2e2e;
$white: white;
// PC
@media screen and (min-width: 640px) {
  header {
    background-color: $black;
    .header-wrapper {
      position: relative;
      width: 90%;
      margin: 0 auto;
      padding: 1.5rem 0;
      .title {
        display: inline-block;
        font-size: 36px;
        font-weight: bold;
        letter-spacing: 5px;

      }
      nav {
        display: inline-block;
        position: absolute;
        right: 0;
        line-height: 36px;
        ul{
          font-size: 0;
        }
        li{
          display: inline-block;
          margin-left: 20px;
        }
        a {
          display: inline-block;
          padding: 0 20px;
          font-size: 18px;
          border: 1px solid white;
          border-radius: 25px;
        }
        a:hover {
          color: $black;
          background: $white;
        }
      }
    }
  }
}
.title, a {
  color: $white;
}
</style>
