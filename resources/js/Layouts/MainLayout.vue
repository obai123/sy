<!-- resources/js/Layouts/MainLayout.vue -->
<template>
    <v-app>
        <v-app-bar color="teal-darken-4">
            <template v-slot:image>
                <v-img
                    gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"
                ></v-img>
            </template>
            <v-app-bar-title>Home</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon>mdi-account-circle</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <!-- Page content will be injected here -->
            <slot></slot>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: "MainLayout",
};
</script>
