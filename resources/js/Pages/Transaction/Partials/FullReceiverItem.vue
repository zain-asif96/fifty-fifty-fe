<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";

const props = defineProps({
    receiver: {
        required: true,
        type: Object
    }
})


</script>

<template>
    <div class="receiver-item-wrapper">
        <div class="receiver-item">
            <FiftyText variation="body-xl" class="title">
                Receiver Information
            </FiftyText>

            <FiftyText>
                First name: <b> {{ receiver.first_name }}</b>
            </FiftyText>

            <FiftyText>
                Last name: <b> {{ receiver.last_name }}</b>
            </FiftyText>

            <FiftyText>
                Email: <b> {{ receiver.email }}</b>
            </FiftyText>

            <FiftyText>
                Phone: <b> {{ receiver.phone }}</b>
            </FiftyText>

            <FiftyText>
                Country: <b> {{ receiver.country }}</b>
            </FiftyText>

            <FiftyText>
                bank: <b> {{ receiver?.bank?.label }}</b>
            </FiftyText>

            <FiftyText>
                Branch Number: <b> {{ receiver.branch_number }}</b>
            </FiftyText>

            <FiftyText>
                Account Number: <b> {{ receiver.account_number }}</b>
            </FiftyText>

            <FiftyText>
                Comments: <b> {{ receiver.banking_info }}</b>
            </FiftyText>
        </div>
    </div>
</template>

<script>
export default {
    name: "FullReceiverItem"
}
</script>
