<script setup>

defineProps({
    product: {
        type: Object
    }
})

</script>

<template>
<div class="table--items3" >
    <p class="table--items--col2">{{product.id}}</p>
    <p class="table--items--col1 table--items--transactionId3">
        {{product.product.description}}
    </p>
    <p class="table--items--col2">$ {{product.unit_price}}</p>
    <p class="table--items--col3">{{product.quantity}}</p>
    <p class="table--items--col5">$ {{ product.unit_price * product.quantity }}</p>
</div>
</template>
