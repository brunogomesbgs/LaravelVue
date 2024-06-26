import { Layout, AddUrl, ListUrl, ListUrlDetails } from '@/views/url'

export default {
  path: '/urls',
  component: Layout,
  children: [
    {path: 'add', component: AddUrl},
    {path: 'list', component: ListUrl},
    {path: 'listUrlWithLinks/:id', component: ListUrlDetails},
    {path: 'update/:id', component: AddUrl}
  ]
};