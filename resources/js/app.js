import { createApp } from 'vue';
import InvoiceComponent from './components/invoice.vue';
import MemberComponent from './components/member.vue';
import ProductComponent from './components/product.vue';
import PrintInvoice from './components/print.vue';

const app = createApp({});
app.component('invoice-component', InvoiceComponent);
app.component('member-component', MemberComponent);
app.component('product-component', ProductComponent);
app.component('print-component', PrintInvoice);
app.mount('#app');
