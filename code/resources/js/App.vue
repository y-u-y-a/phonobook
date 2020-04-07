<template>
    <div>
        <TheHeader />
        <main class="container-fluid">
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
