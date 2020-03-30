<template>
    <div>
        <TheHeader />
        <main>
            <RouterView />
        </main>
    </div>
</template>


<script>
import TheHeader from "./components/TheHeader"

export default {
    components: {
        TheHeader
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
