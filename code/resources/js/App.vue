<template>
    <div>
        <Header />
        <main>
            <RouterView />
        </main>
        <!-- <Footer /> -->
    </div>
</template>


<script>
import Header from "./components/Header";
import Footer from "./components/Footer";

export default {
    components: {
        Header,
        Footer
    }
};
</script>


<style lang="scss">

// PC
@media screen and (min-width: 640px) {
    main {
        // 最小の高さを指定(これより大きくなったら自動的に高さがます)
        // 子要素には継承しない
        // min-height: calc(100vh - 100px - 50px);
    }
    /* 左右にエリアがある場合 */
    .half-box{
        width: 50%;
        // min-height: calc(
        //     100vh - 100px - 50px
        // ); // 親要素が継承できなかったので、同じもの記述
        float: left;
    }
}
</style>
