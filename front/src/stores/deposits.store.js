import { defineStore } from 'pinia'

import { fetchWrapper } from '@/helpers';
import { router } from '@/router/index.js'

const baseUrl = `${import.meta.env.VITE_API_URL}/deposits`;

export const useDepositsStore = defineStore({
    id: 'deposits',
    state: () => ({
        deposits: {},
        deposit: JSON.parse(localStorage.getItem('deposit'))
    }),
    actions: {
        async makeDeposit(userId, value) {
            await fetchWrapper.post(`${baseUrl}/makeDeposit`, {userId: userId, value: value});
        },
        async checkUserBalance(userId, value) {
            this.deposits = { loading: true};
            try {
                this.deposits = await fetchWrapper.get(
                    `${baseUrl}/checkUserBalance`,
                    { userId: userId, value: value }
                );
            } catch (error) {
                this.deposits = { error }
            }
        },
        async listUserBalance(userId) {
            this.deposits = { loading: true };
            try {
                this.deposits = await fetchWrapper.post(
                    `${baseUrl}/listUserBalance`,
                    { userId: userId }
                );
                localStorage.setItem('deposit', JSON.stringify(this.deposits));
            } catch (error) {
                this.deposits = { error }
            }
        },
        async listPendingDeposit() {
            this.deposits = { loading: true };
            try {
                const response = await fetch(`${baseUrl}/listPendingDeposit`);
                this.deposits = await response.json();
            } catch (error) {
                this.deposits = { error };
            }
        },
        async evaluateDeposit(depositId, evaluation) {
            await fetchWrapper.post(
                `${baseUrl}/evaluateDeposit`,
                { depositId: depositId, evaluation: evaluation }
            );

            this.deposits = null
            localStorage.removeItem('deposit');
            await router.push('/');
        }
    }
})