
// publicとresourceをいいいい感じにしてくれる
// コンパイルされないけど外部から読み込むもの
const mix = require('laravel-mix');

mix.js('resources/js/main.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        // エイリアス設定
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias: {
                'colors': __dirname + '/resources/sass/colors.scss',
                '@': __dirname + '/resources/js'
            }
        },
        node: {
            fs: "empty"
        }
    });
