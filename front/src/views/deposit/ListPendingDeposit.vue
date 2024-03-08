<script setup>
import { storeToRefs } from 'pinia';
import { useDepositsStore } from '@/stores';

const depositsStore = useDepositsStore();
const { pendingBalances } = storeToRefs(depositsStore);

let title = 'Pending Deposits List';

depositsStore.listPendingDeposit();
let deposits = JSON.parse(localStorage.getItem('deposit'))
</script>

<template>
  <h1>{{title}}</h1>
  <table class="table table-striped">
    <thead>
    <tr>
      <th style="width: 30%">User</th>
      <th style="width: 30%">Value</th>
      <th style="width: 30%">Actions</th>
      <th style="width: 10%"></th>
    </tr>
    </thead>
    <tbody>
    <template v-if="deposits?.length">
      <tr v-for="pendingBalance in  deposits" :key="pendingBalance.id">
        <td>{{ pendingBalance.user_id }}</td>
        <td>{{ pendingBalance.transit_deposit }}</td>
        <td>{{ pendingBalance.status }}</td>
        <td style="white-space: nowrap">
          <button @click="depositsStore.evaluateDeposit(pendingBalance.id, 1)" class="btn btn-sm btn-success">
            <span>Approve!</span>
          </button>
        </td>
      </tr>
    </template>
    <tr v-if="pendingBalances?.loading">
      <td colspan="4" class="text-center">
        <span class="spinner-border spinner-border-lg align-center"></span>
      </td>
    </tr>
    <tr v-if="pendingBalances?.error">
      <td colspan="4">
        <div class="text-danger">Error loading users: {{pendingBalances?.error}}</div>
      </td>
    </tr>
    </tbody>
  </table>
</template>