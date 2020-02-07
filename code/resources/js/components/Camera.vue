<template>
    <div id="camera">
        <!-- カメラによる動画の挿入 -->
        <video autoplay ref="video" width="300" height="200"></video>
        <!-- 切り取った画像を表示 -->
        <canvas ref="canvas" width="300" height="200"></canvas>
    </div>
</template>


<script>

export default {
    props: [""]
}
</script>


<style lang="scss" scoped>

@import "../../sass/app.scss";

#camera {
    margin: 4rem 0;
    text-align: center;
    video,
    canvas {
        background-color: $white;
        border: 1px solid $silver;
    }
}
</style>
