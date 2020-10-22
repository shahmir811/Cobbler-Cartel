<template>
    <div class="message" :class="type">{{ message }}</div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "Alert",
    computed: {
        ...mapGetters({
            message: "message",
            type: "type"
        })
    }
};
</script>

<style lang="css">
.message {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    position: fixed;
    top: 57px;
    left: 0;
    color: #fff;
    height: 60px;
    width: 100%;
    font-weight: bold;
    z-index: 1;
}

.success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
</style>
