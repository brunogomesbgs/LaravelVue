<script setup>
import { storeToRefs } from 'pinia';

import { useUsersStore } from '@/stores';

const usersStore = useUsersStore();
const { users } = storeToRefs(usersStore);

usersStore.getAll();
</script>

<template>
    <h1>Users</h1>
    <router-link to="/users/add" class="btn btn-sm btn-success mb-2">Add User</router-link>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 30%">Name</th>
                <th style="width: 30%">Email</th>
            </tr>
        </thead>
        <tbody>
            <template v-if="users.length">
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                </tr>
            </template>
            <tr v-if="users.loading">
                <td colspan="2" class="text-center">
                    <span class="spinner-border spinner-border-lg align-center"></span>
                </td>
            </tr>
            <tr v-if="users.error">
                <td colspan="2">
                    <div class="text-danger">Error loading users: {{users.error}}</div>
                </td>
            </tr>            
        </tbody>
    </table>
</template>
