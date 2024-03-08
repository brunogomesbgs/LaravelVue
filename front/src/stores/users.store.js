import { defineStore } from 'pinia';

import { fetchWrapper } from '@/helpers';

const baseUrl = `${import.meta.env.VITE_API_URL}/users`;

export const useUsersStore = defineStore({
    id: 'users',
    state: () => ({
        users: {},
        user: JSON.parse(localStorage.getItem('user'))
    }),
    actions: {
        async register(user) {
            await fetchWrapper.post(
                `${baseUrl}/addUser`,
                { name: user.name, email: user.email, password: user.password }
            );
        },
        async getAll() {
            this.users = { loading: true };
            try {
                const response = await fetch(`${baseUrl}/getAll`);
                this.users = await response.json();
            } catch (error) {
                this.users = { error };
            }
        }
    }
});
