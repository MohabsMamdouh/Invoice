<script setup>
import { useRouter } from 'vue-router';

defineProps({
    invoice: Object
})
const router = useRouter();

const onShow = (id) => {
    router.push('/invoice/show/'+id)
}

</script>

<template>

    <div class="table--items">
        <a href="#" class="table--items--transactionId" @click="onShow(invoice.id)">#{{ invoice.id }}</a>
        <p>{{invoice.invoice_date}}</p>
        <p>#{{invoice.invoice_number}}</p>
        <p v-if="invoice.customer">{{invoice.customer.name}}</p>
        <p v-else>-</p>
        <p>{{invoice.due_date}}</p>
        <p> ${{ invoice.total }}</p>
        <p>{{ invoice.status }}</p>
    </div>
</template>
