import { Layout, List, Add } from '@/views/users';

export default {
    path: '/users',
    component: Layout,
    children: [
        { path: '', component: List },
        { path: 'add', component: Add }
    ]
};
