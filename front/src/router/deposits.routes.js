import { Layout, MakeDeposit, ListUserBalance, ListPendingDeposit } from '@/views/deposit';

export default {
    path: '/deposits',
    component: Layout,
    children: [
        {path: 'makeDeposit', component: MakeDeposit},
        {path: 'listUserBalance', component: ListUserBalance},
        {path: 'listPendingDeposit', component: ListPendingDeposit}
    ]
};