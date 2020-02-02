<template>
  <div id="adminTop">
    <ul class="contents">
      <li>
        <a href="/admin/user" title="User">ユーザーを登録する</a>
      </li>
      <li>
        <a href="/admin/book" title="Book">本を登録する</a>
      </li>
      <li>
        <a href="/admin/edit" title="Edit">本を更新・削除する</a>
      </li>
    </ul>
  </div>
</template>


<style lang="scss" scoped>
$white: white;
$link-red: #fa5858;

// PC
@media screen and (min-width: 640px) {
  #adminTop {
    li {
      border: 1px solid $link-red;
      a {
        color: $link-red;
      }
      a:hover {
        color: $white;
        background: $link-red;
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
