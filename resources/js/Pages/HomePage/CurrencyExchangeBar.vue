<script setup>

import CurrencyRateBox from "@/Pages/HomePage/partials/CurrencyRateBox.vue";

const props = defineProps({
    rates: {
        type: Array,
        default: []
    }
})
</script>

<template>
    <div class="currency-rates-wrapper">
        <div class="currency-boxes flex items-start overflow-hidden marquee shadow-md">
            <CurrencyRateBox v-for="(rate, index) in rates" :key="index" :rate="rate" />
            <CurrencyRateBox v-for="(rate, index) in rates" :key="index" :rate="rate" />
            <CurrencyRateBox v-for="(rate, index) in rates" :key="index" :rate="rate" />
            <CurrencyRateBox v-for="(rate, index) in rates" :key="index" :rate="rate" />
            <CurrencyRateBox v-for="(rate, index) in rates" :key="index" :rate="rate" />
            <CurrencyRateBox v-for="(rate, index) in rates" :key="index" :rate="rate" />
        </div>
    </div>
</template>

<script>
export default{
    name: "CurrencyExchangeBar"
}
</script>
<style lang="scss">
    .currency-rates-wrapper{
        width: 100%;
        display: flex;
        flex-wrap: nowrap;
        overflow: hidden;
        margin-top: 0;

        .currency-boxes{
            margin: auto;
            min-width: fit-content;

            .currency-box{
                background: white;
            }
        }
    }

    .marquee {
        position: relative;
        width: 100vw;
        max-width: 100%;
        overflow-x: hidden;
        animation: marquee 60s linear infinite;
    }

    @keyframes marquee {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

</style>
