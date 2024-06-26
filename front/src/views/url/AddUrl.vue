<script setup>
import { Form, Field } from 'vee-validate';
import * as Yup from 'yup';
import { storeToRefs } from 'pinia';
import { useRoute } from 'vue-router';
import { useUrlsStore, useAlertStore, useAuthStore } from '@/stores';
import { router } from '@/router';
import { ref } from 'vue'

const route = useRoute();
const id = route.params.id;
const urlsStore = useUrlsStore();
const alertStore = useAlertStore()
const authStore = useAuthStore();

let title = 'Add Url';
let url = ref({name: null, url: null});

let name = defineModel('name')
let url_value = defineModel('url')

if (id) {
  title = 'Edit Url';
  urlsStore.listUrl(id);
  ({ url } = storeToRefs(urlsStore));
  name.value = url.value.name
  url_value.value = url.value.url
}

const schema = Yup.object().shape({
  name: Yup.string()
    .required('Name is required'),
  url: Yup.string()
    .required('Url is required')
});

const { user }  = storeToRefs(authStore);

async function onSubmit(values) {
  try {
    let message
    if (values.name && values.url && id) {
      await urlsStore.updateUrl(id, user.value[0].id, values.name, values.url);
      message = "Url updated successfully";
    } else {
      await urlsStore.addUrl(user.value[0].id, values.name, values.url);
      message = "Url saved";
    }

    await router.push('/');
    alertStore.success(message)
  } catch (error) {
    alertStore.error(error);
  }
}
</script>

<template>
  <h1>{{title}}</h1>
  <template v-if="!(url?.loading || url?.error)">
    <Form @submit="onSubmit" :validation-schema="schema" :initial-values="url" v-slot="{ errors, isSubmitting }">
      <div class="form-group">
        <label>Name</label>
        <Field name="name" v-model="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }" />
        <div class="invalid-feedback">{{ errors.name }}</div>
      </div>
      <div class="form-group">
        <label>Url</label>
        <Field name="url" v-model="url_value" type="text" class="form-control" :class="{ 'is-invalid': errors.url }" />
        <div class="invalid-feedback">{{ errors.url }}</div>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" :disabled="isSubmitting">
          <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
          Save Url
        </button>
        <router-link to="/urls/list" class="btn btn-link">List User´s Url</router-link>
      </div>
    </Form>
  </template>

  <template v-if="url?.loading">
    <div class="text-center m-5">
      <span class="spinner-border spinner-border-lg align-center"></span>
    </div>
  </template>
  <template v-if="url?.error">
    <div class="text-center m-5">
      <div class="text-danger">Error loading url: {{url.error}}</div>
    </div>
  </template>
</template>
