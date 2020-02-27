<template>
    <div>
        <Header />
        <main>
            <RouterView />
        </main>
    </div>
</template>


<script>
import Header from "./components/Header"

export default {
    components: {
        Header
    }
}
</script>


<style lang="scss">

// PC
@media screen and (min-width: 640px) {
    .half-box{
        width: 50%;
        float: left;
    }
}
</style>
