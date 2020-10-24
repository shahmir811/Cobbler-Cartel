<template>
    <div class="admin-users-managment-wrapping-div">
        <template v-if="!loading">
            <h1 class="admin-users-page-title">Users Management</h1>
            <b-row>
                <router-link to="/admin/add-user">
                    <b-button class="admin-users-component-add-new-user-button"
                        >Add User</b-button
                    >
                </router-link>
            </b-row>
            <b-row>
                <table class="table table-hover">
                    <thead class="table-header-class">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="totalUsers > 0">
                        <tr v-for="(user, index) in users" :key="user.id">
                            <td scope="row">{{ ++index }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ capitalize(user.role) }}</td>
                            <td>
                                <router-link
                                    class="update-user-link"
                                    :to="{
                                        name: 'admin-update-user',
                                        params: { id: user.id }
                                    }"
                                >
                                    <i
                                        class="fa fa-pencil"
                                        aria-hidden="true"
                                    ></i>
                                </router-link>
                                <a href="#" class="update-user-delete-link"
                                    ><i
                                        class="fa fa-trash-o"
                                        aria-hidden="true"
                                    ></i
                                ></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </b-row>
        </template>
        <template v-else>
            <b-card>
                <b-skeleton animation="wave" width="85%"></b-skeleton>
                <b-skeleton animation="wave" width="55%"></b-skeleton>
                <b-skeleton animation="wave" width="70%"></b-skeleton>
            </b-card>
        </template>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "Admin-Users",
    mounted() {
        this.fetchUsers();
    },
    computed: {
        ...mapGetters({
            users: "user/users",
            loading: "user/loading",
            totalUsers: "user/totalUsers"
        })
    },
    data() {
        return {
            userId: null,
            newPassword: null
        };
    },
    methods: {
        ...mapActions({
            fetchUsers: "user/fetchUsers",
            UpdateUserPassword: "user/UpdateUserPassword"
        }),
        capitalize(role) {
            return role[0].toUpperCase() + role.slice(1);
        }
    }
};
</script>

<style lang="scss" scoped>
@import "../../../styles/styles.scss";

.table-header-class {
    background: $BROWN-5;
}

.update-user-delete-link {
    color: $RED-3;
}

.admin-users-page-title {
    text-decoration: underline;
    color: $BROWN-12 !important;
    margin: 15px 0px;
}

.admin-users-component-add-new-user-button {
    width: 117px;
    height: 45px;
    background: $BROWN-10 !important;
    margin-bottom: 15px;

    a {
        @extend .regular-16px-24px;
        color: $GREY-1 !important;

        &:hover {
            outline: none;
            border: none;
        }

        &:hover {
            @extend .regular-16px-24px;
            background: $BROWN-11 !important;
        }
    }
}

.modal-title {
    padding-left: 130px;
    color: $BROWN-12 !important;
}
</style>
