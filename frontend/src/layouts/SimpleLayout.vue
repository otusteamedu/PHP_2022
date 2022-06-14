<template>
    <v-app>
        <v-app-bar app
                   dark
                   color="deep-purple accent-4"
        >
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-toolbar-title>Events</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-app-bar>
        <v-main class="pt-0 px-5">
            <v-container fluid>
                <slot/>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: "SimpleLayout"
}
</script>

<style scoped>

</style>