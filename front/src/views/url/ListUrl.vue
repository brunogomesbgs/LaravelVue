<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore, useUrlsStore } from '@/stores/index.js'

let title = "User´s Url List"

const urlsStore = useUrlsStore();
const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
const { urls } = storeToRefs(urlsStore);

urlsStore.listAllUrl(user.value[0].id)
</script>

<template>
  <h1>{{title}}</h1>
  <h6>If your recent data doesnt show, try reload the page!</h6>
  <router-link to="/urls/add" class="btn btn-sm btn-success mb-2">Add Url</router-link>
  <table class="table table-striped">
    <thead>
    <tr>
      <th style="width: 30%">Name</th>
      <th style="width: 30%">Url</th>
      <th style="width: 30%">Total links</th>
      <th style="width: 30%"></th>
    </tr>
    </thead>
    <tbody>
    <template v-if="urls.length">
      <tr v-for="url in urls" :key="url.id">
        <td>{{ url.name }}</td>
        <td>{{ url.url }}</td>
        <td>{{ url.links_account }}</td>
        <td style="white-space: nowrap">
          <router-link :to="`/urls/update/${url.id}`" class="btn btn-sm btn-warning mr-1">Edit</router-link>
          <router-link :to="`/urls/listUrlWithLinks/${url.id}`" class="btn btn-sm btn-primary mr-1">Details</router-link>
          <button @click="urlsStore.deleteUrl(url.id)" class="btn btn-sm btn-danger btn-delete-user" :disabled="url.isDeleting">
            <span v-if="url.isDeleting" class="spinner-border spinner-border-sm"></span>
            <span v-else>Delete</span>
          </button></td>
      </tr>
    </template>
    <tr v-if="urls.loading">
      <td colspan="2" class="text-center">
        <span class="spinner-border spinner-border-lg align-center"></span>
      </td>
    </tr>
    <tr v-if="urls.error">
      <td colspan="2">
        <div class="text-danger">Error loading url: {{urls.error}}</div>
      </td>
    </tr>
    </tbody>
  </table>
</template>
