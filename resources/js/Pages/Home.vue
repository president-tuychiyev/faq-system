<script setup>
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    faqs: [],
    idn: {}
})

const details = reactive({
    top: props.idn.top,
    bottom: props.idn.bottom
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
                <n-collapse-item v-for="faq in  faqs " :title="customTitle(faq.quest)" class="!border-0">
                    <div :style="`margin-top: ${details.top}px; margin-bottom: ${idn.bottom}px`">{{ faq.answer }}
                    </div>
                </n-collapse-item>
            </n-collapse>
        </div>
    </div>
</template>
