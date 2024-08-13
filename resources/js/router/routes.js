import InvoiceIndex from '../components/invoices/index.vue'
import InvoiceNew from '../components/invoices/new.vue'
import InvoiceShow from '../components/invoices/show.vue'
import InvoiceEdit from '../components/invoices/edit.vue'
import NotFound from '../components/NotFound.vue'

const routes = [
    {
        path: '/',
        name: 'invoice',
        component: InvoiceIndex,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound,
    },
    {
        path: '/invoice/new/',
        name: 'newInvoice',
        component: InvoiceNew,
    },
    {
        path: '/invoice/show/:id',
        name: 'showInvoice',
        component: InvoiceShow,
        props: true,
    },
    {
        path: '/invoice/edit/:id',
        name: 'editInvoice',
        component: InvoiceEdit,
        props: true,
    },
]

export default routes
