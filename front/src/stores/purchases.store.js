import { defineStore } from 'pinia';

import { fetchWrapper } from '@/helpers';

const baseUrl = `${import.meta.env.VITE_API_URL}/purchases`;

export const usePurchasesStore = defineStore({
    id: 'purchases',
    state: () => ({
        purchase: JSON.parse(localStorage.getItem('purchase')),
        purchases: {}
    }),
    actions: {
        async makePurchase(userId, value, description) {
            await fetchWrapper.post(
                `${baseUrl}/makePurchase`,
                { userId: userId, value: value, description: description }
            );
        }
    }
})