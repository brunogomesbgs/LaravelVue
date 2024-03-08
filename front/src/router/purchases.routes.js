import { Layout, MakePurchase } from '@/views/purchase';

export default {
    path: '/purchases',
    component: Layout,
    children: [
        { path: '', component: MakePurchase }
    ]
};