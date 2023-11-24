<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import Modal from "@/Components/Custom/Modal.vue";
import { onMounted, ref } from "vue";

const props = defineProps({
    supportedCountries: {
        required: true,
        default: [],
        type: Array,
    },
});

const isModalOpened = ref(false);
const allSupportedCountries = ref([]);


const closeModal = () => {
    isModalOpened.value = false;
};
const openModal = (e) => {
    e.preventDefault();
    isModalOpened.value = true;
};
onMounted(()=>{
    if(props.supportedCountries.length){
        let tempCountries=props.supportedCountries
        let filterSupported=props.supportedCountries?.filter((spCountry)=>['ng' , 'us' , 'ca'].includes(spCountry?.code_iso_2?.toLowerCase()))

        for (const [i,item] of tempCountries.entries()) {
                if(['ng' , 'us' , 'ca'].includes(item?.code_iso_2?.toLowerCase())){
                    tempCountries.splice(i,1)
                }
        }
        for (const [i,item] of filterSupported.entries()) {
                
                    tempCountries.unshift(item)
        }
        allSupportedCountries.value=tempCountries



    }
})

</script>

<template>
    <div class="bg-white">
        <div class="hero-section-six-container inside-container">
            <FiftyText color="dark" variation="heading-2">
                <!-- Exchange money across over 120+ more countries. Coming Soon! -->
                Exchange currencies across Canada, Nigeria and the US. 120+ other countries. Real Soon!

            </FiftyText>

            <div class="countries">
                <div
                    v-for="country in allSupportedCountries.slice(0, 25)"
                    :key="country"
                    :class="['country',{'country-show': !['ng' , 'us' , 'ca'].includes(country.code_iso_2.toLowerCase()) }]"
                >
                    <img
                        :src="`images/countries/${country.code_iso_2.toLowerCase()}.png`"
                        alt="country"
                    />
                    <div class="border-b">
                        {{ country.label }}
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <Modal
                    :close="closeModal"
                    :isOpen="isModalOpened"
                    header="List of supported countries"
                    width="wide"
                >
                    <template #button>
                        <NewActionButton
                            @click="openModal"
                            class="w-fit"
                            title="See Full List Of Countries"
                        />
                    </template>

                    <template #content>
                        <div class="countries" style="padding: 25px 0">
                            <div
                                v-for="country in supportedCountries"
                                :key="country"
                                :class="['country',{'country-show': !['ng' , 'us' , 'ca'].includes(country.code_iso_2.toLowerCase()) }]"

                            >
                                <img
                                    :src="`images/countries/${country.code_iso_2.toLowerCase()}.png`"
                                    alt="country"
                                />
                                <div class="border-b">
                                    {{ country.label }}
                                </div>
                            </div>
                        </div>
                    </template>
                </Modal>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HeroSectionSix",
};
</script>
