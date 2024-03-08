<script setup>
import { Form, Field } from 'vee-validate';
import * as Yup from 'yup';
import { storeToRefs } from 'pinia';

import { usePurchasesStore, useAlertStore, useAuthStore } from '@/stores';
import { router } from '@/router';

const purchasesStore = usePurchasesStore();
const alertStore = useAlertStore();

let title = 'Make Purchase';
let purchase = null;

const schema = Yup.object().shape({
  value: Yup.string()
      .required('Value is required'),
  description: Yup.string()
      .required('Description is required')
});

const authStore = useAuthStore();
const { user } = storeToRefs(authStore);

async function onSubmit(values) {
  try {
    let message;
    await purchasesStore.makePurchase(user.value[0].id, values.value, values.description);
    message = "Purchase made";

    await router.push('/purchases');
    alertStore.success(message);
  } catch (error) {
    alertStore.error(error);
  }
}
</script>

<template>
  <h1>{{title}}</h1>
  <template v-if="!(purchase?.loading || purchase?.error)">
    <Form @submit="onSubmit" :validation-schema="schema" :initial-values="purchase" v-slot="{ errors, isSubmitting }">
      <div class="form-group">
        <label>Purchase´s Value</label>
        <Field name="value" type="number" class="form-control" :class="{ 'is-invalid': errors.values }" />
        <div class="invalid-feedback">{{ errors.values }}</div>
      </div>
      <div class="form-group">
        <label>Description</label>
        <Field name="description" type="text" class="form-control" :class="{ 'is-invalid': errors.description }" />
        <div class="invalid-feedback">{{ errors.description }}</div>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" :disabled="isSubmitting">
          <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
          Make Purchase
        </button>
        <router-link to="/deposits/makeDeposit" class="btn btn-link">Make Deposit</router-link>
        <router-link to="/deposits/listUserBalance" class="btn btn-link">List User´s Deposit</router-link>
      </div>
    </Form>
  </template>
  <template v-if="purchase?.loading">
    <div class="text-center m-5">
      <span class="spinner-border spinner-border-lg align-center"></span>
    </div>
  </template>
  <template v-if="purchase?.error">
    <div class="text-center m-5">
      <div class="text-danger">Error loading purchase: {{purchase.error}}</div>
    </div>
  </template>
</template>