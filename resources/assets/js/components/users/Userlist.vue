<script>
import EditUser from './EditUser';
import Vue from 'vue';

export default {
    data() {
        return {
            users: this.initial_users,
        }
    },

    props: {
        initial_users: {
            required: true,
        }
    },

    mounted() {
        this.$root.$on('userEdited', (user) => {
            Vue.set(this.users, user.id, user);
        });
    },

    components: {
        edituser: EditUser,
    },

    methods: {
        userClicked(user) {
            this.$root.$emit('editUser', user);
        }
    }
}
</script>

<template>
<div id="userlist">
    <ul>
        <li v-for="user in users"><a href="#" @click.prevent="(userClicked(user))">{{ user.name }}</a></li>
    </ul>
    <edituser></edituser>
</div>
</template>
