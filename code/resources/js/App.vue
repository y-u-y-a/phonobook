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
    .flex{
        display: flex;
    }
    .half-box{
        display: inline-block;
        width: 50%;
    }
}
</style>
