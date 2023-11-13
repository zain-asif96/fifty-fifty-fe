<script setup>

import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    rate: {
        type: Object,
        default: {}
    }
})

const geoLocationDetails = usePage().props.geoDetails;

const flagsMap = {
    USD : 'images/countries/us.png',
    EUR : 'images/countries/eu.png',
    CAD : 'images/countries/ca.png',
    GBP : 'images/countries/gb.png',
};

</script>

<template>
    <div class="currency-box pair w-48 px-3 py-2 border-r border-b border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div class="flex -space-x-1 overflow-hidden flags">
                    <div class="image-wrapper">
                        <img class="inline-block flex" :src="`images/countries/${geoLocationDetails.country.code_iso_2.toLowerCase()}.png`"  alt="flag">
                    </div>
                    <div class="image-wrapper" v-if="geoLocationDetails.country.currency.code !== rate['code']">
                        <img class="inline-block flex" :src="flagsMap[rate['code']]" alt="flag" >
                    </div>
                </div>
            </div>
            <div class="flex mt-2 justify-between items-center">
                <span id="USD_EUR" class="font-semibold text-md text-gray-800">
                    {{ parseFloat(rate['value']).toFixed(4) }}
                </span>

                <span class="font-semibold text-sm text-gray-800">
                            {{geoLocationDetails.country.currency.code}} / {{ rate['code'] }}
                </span>
            </div>
        </div>
</template>

<script>
export default{
    name: "CurrencyRateBox"
}
</script>

<style lang="scss">
.flags{
    display: flex;
    align-items: center;
    .image-wrapper{
        width: 38px;
        height: 38px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: white solid 2px;

        img{
            min-width: 55px;
            min-height: 35px;
            border: 1px white solid;
        }
    }

}
</style>
