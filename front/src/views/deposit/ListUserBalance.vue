<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore, useDepositsStore } from '@/stores';

let title = 'User´s Balance List';

const depositsStore = useDepositsStore();
const authStore = useAuthStore();
const { user } = storeToRefs(authStore);
let balance = JSON.parse(localStorage.getItem('deposit'))

depositsStore.listUserBalance(user.value[0].id);

let amount_available = null

if (balance[0] != null && user.value[0].isAdmin === 0) {
  amount_available = balance[0].current_deposit - balance[0].transit_deposit
}
</script>

<template>
  <h1>{{title}}</h1>
  <router-link to="/deposits/makeDeposit" class="btn btn-sm btn-success mb-2">Make Deposit</router-link>
  <router-link to="/purchases" class="btn btn-link">Make Purchase</router-link>
  <div v-if="amount_available > 0">
    <h3>Your current balance is {{ amount_available }}</h3>
  </div>
</template>