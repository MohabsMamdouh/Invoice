<script setup>
import {onMounted, ref} from 'vue'
import InvoiceItem from './InvoiceItem.vue'
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

let invoices = ref([])

let searchInvovice = ref([])

onMounted(async () => {
    getInvoices()
    search()
})

const getInvoices = async () => {
    let response = await axios.get('/api/get_invoices')

    // console.log('response', response)

    invoices.value = response.data.invoices
}


const search = async () => {
    let response = await axios.get('/api/search_invoice?s='+searchInvovice.value)

    // console.log('response', response.data.response)

    invoices.value = response.data.invoices
}

const newInvoice = async () => {
    let form = await axios.get('/api/create_invoice')
    // console.log('form', form.data)
    router.push('/invoice/new')
}

</script>
<template>
    <div class="container">
        <div class="invoices">

        <div class="card__header">
            <div>
                <h2 class="invoice__title">Invoices</h2>
            </div>
            <div>
                <button class="btn btn-secondary" @click="newInvoice()">
                    New Invoice
                </button>
            </div>
        </div>

        <div class="table card__content">
            <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                <div class="table--filter--listWrapper">
                    <ul class="table--filter--list">
                        <li>
                            <p class="table--filter--link table--filter--link--active">
                                All
                            </p>
                        </li>
                        <li>
                            <p class="table--filter--link ">
                                Paid
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table--search">
                <div class="table--search--wrapper">
                    <select class="table--search--select" name="" id="">
                        <option value="">Filter</option>
                    </select>
                </div>
                <div class="relative">
                    <i class="table--search--input--icon fas fa-search "></i>
                    <input class="table--search--input"
                            v-model="searchInvovice" @keyup="search()"
                            type="text"
                            placeholder="Search invoice">
                </div>
            </div>

            <div class="table--heading">
                <p>ID</p>
                <p>Date</p>
                <p>Number</p>
                <p>Customer</p>
                <p>Due Date</p>
                <p>Total</p>
                <p>Status</p>
            </div>

            <!-- item 1 -->
            <InvoiceItem v-for="invoice in invoices" :invoice="invoice" v-if="invoices.length > 0" />
            <div class="table--items" v-else>
                <p>Invoice Not Found</p>
            </div>
        </div>

    </div>

    <br><br><br>
    </div>
</template>
