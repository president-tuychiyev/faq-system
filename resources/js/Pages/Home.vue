<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    faqs: [],
})

const customTitle = (title) => {
    return h("p", { class: "font-bold" }, { default: () => title })
}

</script>

<template>
    <Head title="Home page" />
    <div class="bg-gray-200 h-screen">
        <div class="mx-5 md:mx-24 pt-5 md:pt-20">
            <n-h1 class="font-bold">Ответы на вопросы</n-h1>
            <n-collapse arrow-placement="right">
                <n-collapse-item v-for="faq in faqs" :title="customTitle(faq.quest)" class="!border-0">
                    <div>{{ faq.answer }}</div>
                </n-collapse-item>
            </n-collapse>
        </div>
    </div>
</template>
