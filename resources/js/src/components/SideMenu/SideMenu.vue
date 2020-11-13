<template>
    <div class="sidemenu-component-wrapping-div">
        <template v-if="role === 'admin'">
            <router-link to="/home" class="side-menu-links">Home</router-link>
            <router-link to="/users" class="side-menu-links"
                >Users Management</router-link
            >
            <router-link to="/orders" class="side-menu-links"
                >Order Management</router-link
            >
            <router-link to="/completed-orders" class="side-menu-links"
                >Completed Orders</router-link
            >
            <router-link to="/items" class="side-menu-links"
                >Items Management</router-link
            >
            <router-link to="/inventory" class="side-menu-links"
                >Inventory Management</router-link
            >
            <router-link to="/purchases" class="side-menu-links"
                >Purchase Management</router-link
            >        
            <a href="#" class="side-menu-links">Scan QR code</a>
            <router-link to="/import-file" class="side-menu-links"
                >Import Excel File</router-link
            >
        </template>
        <template v-else>
            <router-link to="/home" class="side-menu-links">Home</router-link>
            <router-link to="/orders" class="side-menu-links"
                >Order Management</router-link
            >
            <router-link to="/completed-orders" class="side-menu-links"
                >Completed Orders</router-link
            >
            <router-link to="/inventory" class="side-menu-links"
                >Inventory Management</router-link
            >        
            <a href="#" class="side-menu-links">Scan QR code</a>
            <router-link to="/import-file" class="side-menu-links"
                >Import Excel File</router-link
            >            
        </template>
    </div>
</template>

<script>

import { mapGetters, mapActions} from 'vuex';

export default {
    name: "SideMenu",
    computed: {
        ...mapGetters({
            role: 'auth/role'
        })
    },
};
</script>

<style lang="scss" scoped>
@import "../../styles/styles.scss";

.sidemenu-component-wrapping-div {
    border: 1px solid $SIDEMENU_BORDER_COLOR;
    height: 500px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    // align-items: center;
}

.side-menu-links {
    height: 47px;
    // border: 1px solid $SIDEMENU_BORDER_COLOR;
    color: $SIDEMENU_LINKS_COLOR !important;
    display: flex;
    justify-content: center;
    align-items: center;

    &:hover {
        color: $SIDEMENU_LINKS_HOVER_COLOR !important;
        background-color: $SIDEMENU_LINKS_HOVER;
    }
}
</style>
