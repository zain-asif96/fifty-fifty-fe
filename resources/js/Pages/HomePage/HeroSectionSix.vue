<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import Modal from "@/Components/Custom/Modal.vue";
import { ref } from "vue";

const props = defineProps({
    supportedCountries: {
        required: true,
        default: [],
        type: Array,
    },
});

const isModalOpened = ref(false);

const closeModal = () => {
    isModalOpened.value = false;
};
const openModal = (e) => {
    e.preventDefault();
    isModalOpened.value = true;
};
</script>

<template>
    <div class="bg-white">
        <div class="hero-section-six-container inside-container">
            <FiftyText color="dark" variation="heading-2">
                Exchange money across over 120+ more countries. Coming Soon!
            </FiftyText>

            <div class="countries">
                <div
                    v-for="country in supportedCountries.slice(1, 26)"
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
