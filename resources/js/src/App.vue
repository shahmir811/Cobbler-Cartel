<template>
    <div>
        <Navbar />
        <Alert v-if="message" />
        <b-container fluid>
            <template v-if="isAuthenticated">
                <b-row class="text-center">
                    <b-col cols="2" class="left-sidemenu-column">
                        <SideMenu />
                    </b-col>
                    <b-col cols="10">
                        <router-view></router-view>
                    </b-col>
                </b-row>
            </template>
            <template v-else>
                <router-view></router-view>
            </template>
        </b-container>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

import Alert from "./components/Alert/Alert";
import Navbar from "./components/Navbar/Navbar";
import SideMenu from "./components/SideMenu/SideMenu";

export default {
    name: "App",
    computed: {
        ...mapGetters({
            message: "message",
            isAuthenticated: "auth/isAuthenticated"
        })
    },
    components: {
        Alert,
        Navbar,
        SideMenu
    } // components end here
};
</script>

<style lang="scss">
* {
    font-family: "Roboto", sans-serif;
    box-sizing: border-box;
}

body {
    margin: 0px;
    padding: 0px 0px 40px 0px;
}

.left-sidemenu-column {
    padding-left: 0px !important;
}
</style>
