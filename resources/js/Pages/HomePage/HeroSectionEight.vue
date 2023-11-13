<script setup>
import FiftyText from "@/Components/Design/FiftyText.vue";
import { reactive, ref } from "vue";

const questions = reactive([
    {
        title: "how-it-works",
        question: "How does fiftyfifty work?",
        answer: "FiftyFifty is a digital remittance service on a mission to make the money transfer process faster, affordable, and more transparent. We are a digital service with a robust security platform to execute secure peer-2-peer transactions; therefore, we can keep our costs low and pass those savings on to you!",
        urlText: "Learn more about how fiftyfifty transfer works",
        url: "#",
        isOpened: true,
    },
    {
        title: "is-it-secure",
        question: "Is fiftyfifty a safe and secure way to send money?",
        answer:
            "Yes it is! fiftyfifty is a reliable and secure service that follows internet security and data privacy best practices.  " +
            "fiftyfifty uses secure sockets layer (SSL) protocol technology with 128-bit data encryption to secure all transactions and data operations on our platform. " +
            "All card details are handled using a certified PCI Service Provider Level 1. This is the most stringent level of certification available in the payments industry.",

        urlText: "Learn more about how fiftyfifty security rules",
        url: "#",
        isOpened: false,
    },
    {
        title: "cost",
        question: "How much does fiftyfifty cost?",
        answer: "We also believe in free market enterprise. Hence, our users can enjoy transactions at the actual market prices, ensuring better currency conversion rates and more money for the receiver. Moreover, because we eliminate the intermediaries and the user makes payments directly to themselves, we collect close-to-zero transaction fees! One unit of the Sender's local currency while the receiver pays nothing!",
        urlText: "Learn more about how fiftyfifty Cost",
        url: "#",
        isOpened: false,
    },
    {
        title: "fees",
        question: "What are the fees for using fiftyfifty money transfer?",
        answer: "One unit of the Sender's local currency! The receiver pays nothing! For example, if you are in New York City USA and send $459 to India, you incur a $1 transaction fee o. However, if you are in London, UK, and send mum £80 in South Africa, it costs you £1! This savings can be close to 95% compared to traditional methods.",
        urlText: "Learn more about how fiftyfifty fees",
        url: "#",
        isOpened: false,
    },
    {
        title: "time",
        question: "How long does it take for a money transfer to be completed?",
        answer: "It takes between 30 minutes to 3 Hours for transactions to be complete. We automatically review and authenticate legitimate and correct transactions at every step! We work hard to help find a peer who is willing to trade and help you make local payments wherever your receiver is!",
        urlText: "Learn more about how fiftyfifty transfer timeframe",
        url: "#",
        isOpened: false,
    },
]);

const toggleQuestion = (title) => {
    const question = questions.find((q) => {
        return q.title === title;
    });

    console.log({ question });

    question.isOpened = !question.isOpened;
};
</script>

<template>
    <div id="faq" class="hero-section-eight-container">
        <div class="inside-container">
            <FiftyText color="dark" variation="heading-2">
                Frequently Asked Questions
            </FiftyText>

            <div class="questions-container">
                <div class="questions">
                    <div
                        v-for="question in questions"
                        :key="question.title"
                        :class="{ active: question.isOpened }"
                        class="question"
                    >
                        <div
                            class="header"
                            @click="toggleQuestion(question.title)"
                        >
                            <div class="title">
                                {{ question.question }}
                            </div>
                            <div class="arrow">^</div>
                        </div>

                        <div class="answer">
                            {{ question.answer }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HeroSectionEight",
};
</script>
