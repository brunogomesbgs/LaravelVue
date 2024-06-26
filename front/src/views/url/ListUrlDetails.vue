<script setup>
import { storeToRefs } from 'pinia';
import { useRoute } from 'vue-router';

import { useUrlsStore } from '@/stores';
const route = useRoute();
const id = route.params.id;

const urlsStore = useUrlsStore();
const { urls } = storeToRefs(urlsStore);

let title = 'List Url Details';
urlsStore.listUrlWithLinks(id);
</script>

<template>
  <h1>{{title}}</h1>
  <router-link to="/urls/list" class="btn btn-sm btn-success mb-2">List Url</router-link>
  <table class="table table-striped">
    <thead>
    <tr>
      <th style="width: 30%">Name</th>
      <th style="width: 30%">Link</th>
    </tr>
    </thead>
    <tbody>
    <template v-if="urls.length">
      <tr v-for="url in urls" :key="url.id">
        <td>{{ url.name }}</td>
        <td>{{ url.link }}</td>
      </tr>
    </template>
    <tr v-if="urls.loading">
      <td colspan="2" class="text-center">
        <span class="spinner-border spinner-border-lg align-center"></span>
      </td>
    </tr>
    <tr v-if="urls.error">
      <td colspan="2">
        <div class="text-danger">Error loading users: {{urls.error}}</div>
      </td>
    </tr>
    </tbody>
  </table>
</template>
