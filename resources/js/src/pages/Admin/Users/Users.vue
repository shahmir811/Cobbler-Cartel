<template>
    <div class="admin-users-managment-wrapping-div">
        <template v-if="!loading">
            <h1>Users Management</h1>

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
                            <a href="#" class="update-user-link"
                                ><i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="update-user-password-link"
                                ><i class="fa fa-key" aria-hidden="true"></i
                            ></a>
                            <a href="#" class="update-user-delete-link"
                                ><i class="fa fa-trash-o" aria-hidden="true"></i
                            ></a>
                        </td>
                    </tr>
                </tbody>
            </table>
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
        // capitalizeFirstLetter(role) {
        //     return role[0].toUpperCase() + role.slice(1);
        // }
    },
    methods: {
        ...mapActions({
            fetchUsers: "user/fetchUsers"
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
</style>
