<script setup>
import { Form, Field } from 'vee-validate';
import * as Yup from 'yup';
import { storeToRefs } from 'pinia';

import { useDepositsStore, useAlertStore, useAuthStore } from '@/stores';
import { router } from '@/router';

const depositsStore = useDepositsStore();
const alertStore = useAlertStore();

let title = 'Make Deposit';
let deposit = null;

const schema = Yup.object().shape({
  value: Yup.string()
      .required('Value is required')
});

const authStore = useAuthStore();
const { user }  = storeToRefs(authStore);
async function onSubmit(values) {
  try {
    let message;
    await depositsStore.makeDeposit(user.value[0].id, values.value);
    message = "Deposit made";

    await router.push('/');
    alertStore.success(message);
  } catch (error) {
    alertStore.error(error);
  }
}
</script>

<template>
  <h1>{{title}}</h1>
  <template v-if="!(deposit?.loading || deposit?.error)">
    <Form @submit="onSubmit" :validation-schema="schema" :initial-values="deposit" v-slot="{ errors, isSubmitting }">
      <div class="form-group">
        <label>Deposit´s Value</label>
        <Field name="value" type="number" class="form-control" :class="{ 'is-invalid': errors.values }" />
        <div class="invalid-feedback">{{ errors.values }}</div>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" :disabled="isSubmitting">
          <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
          Make Deposit
        </button>
        <router-link to="/purchases" class="btn btn-link">Make Purchase</router-link>
        <router-link to="/deposits/listUserBalance" class="btn btn-link">List User´s Deposit</router-link>
      </div>
    </Form>
  </template>
  <template v-if="deposit?.loading">
    <div class="text-center m-5">
      <span class="spinner-border spinner-border-lg align-center"></span>
    </div>
  </template>
  <template v-if="deposit?.error">
    <div class="text-center m-5">
      <div class="text-danger">Error loading deposit: {{deposit.error}}</div>
    </div>
  </template>
</template>