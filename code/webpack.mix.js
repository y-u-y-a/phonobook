
// publicとresourceをいいいい感じにしてくれる
// コンパイルされないけど外部から読み込むもの
const mix = require("laravel-mix");

mix.js("resources/js/main.js", "public/js")
  .sass("resources/sass/app.scss", "public/css")
  .webpackConfig({
    node: {
      fs: "empty"
    },
    // パスに"@"を使えるようにする
    // resolve: {
    //     extensions: ['.js', '.vue', '.json'],
    //     alias: {
    //         'vue$': 'vue/dist/vue.esm.js',
    //         '@': __dirname + '/resources/assets/js'
    //     }
    // },
  });
