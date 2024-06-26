<script setup>
import { storeToRefs } from 'pinia';

import { useAuthStore } from '@/stores';

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
</script>

<template>
    <div v-if="user">
        <h1>Hi {{ user[0].name }}!</h1>
        <p>You can interact by navigating within the upper navigation tabs! Enjoy!</p>
      <router-link to="/urls/add" class="btn btn-link">Add an Url</router-link>
    </div>
</template>
