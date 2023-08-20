<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { NButtonGroup, NButton, NPopconfirm, NTag, useMessage } from 'naive-ui'
import { Pencil, TrashOutline, Add } from '@vicons/ionicons5'
import moment from 'moment';
const message = useMessage()

defineProps({
    faqs: { data: [] }
})

const details = reactive({
    showModal: false,
    columns: [
        {
            title: "ID",
            width: 80,
            key: 'id',
            sorter: 'default'
        },
        {
            title: "Вопрос",
            width: 150,
            key: 'quest',
            sorter: 'default'
        },
        {
            title: "Ответ",
            width: 250,
            key: 'answer',
            sorter: 'default'
        },
        {
            title: "Автор",
            width: 150,
            render: (row) => {
                return row.creator.name
            }
        },
        {
            title: "Дата создания",
            width: 150,
            key: 'created_at',
            render(row) {
                return moment(row.created_at).format("DD.MM.YYYY | HH:mm")
            },
            sorter: 'default'
        },
        {
            title: "Дата обновления",
            width: 200,
            key: 'updated_at',
            render(row) {
                return moment(row.updated_at).format("DD.MM.YYYY | HH:mm")
            },
            sorter: 'default'
        },
        {
            title: "Очередь",
            width: 150,
            key: 'turn',
            align: 'center',
            render(row) {
                return row.turn ? h(NTag, { size: 'small', type: 'info' }, { default: () => row.turn }) : h(NTag, { size: 'small', type: 'warning' }, { default: () => 'простое значение' })
            },
            sorter: 'default'
        },
        {
            title: 'Действия',
            align: 'center',
            width: 100,
            render: (row) => {
                return h(NButtonGroup, null, {
                    default: () => [
                        h(NButton, { onClick: () => show(row) }, { default: () => h(renderIcon(Pencil)) }),
                        h(NPopconfirm, { negativeText: null, positiveText: 'Да', onPositiveClick: () => destroy(row) }, { trigger: () => h(NButton, null, { default: () => h(renderIcon(TrashOutline)) }), default: () => "Вы уверены, что хотите это удалить?" })
                    ]
                })
            }
        }
    ],
    body: [
        {
            quest: "",
            answer: "",
            turn: "",
        }
    ]
})

const collapseCreate = () => {
    return {
        quest: "",
        answer: ""
    }
}

const onlyAllowNumber = (value) => !value || /^\d+$/.test(value)

const store = () => {
    router.post(route('faq.store'), details.body, {
        onSuccess(page) {
            message.success(page.props.message)
            details.showModal = false
        },
        onError(page) {
            message.error(page.props.message)
            details.showModal = false
        }
    })
}

const show = (row) => {
    details.body = row
    details.showModal = true
}

const update = () => {
    router.post(route('faq.update'), details.body, {
        onSuccess(page) {
            message.success(page.props.message)
            details.showModal = false
        }
    })
}

const destroy = (row) => router.post(route('faq.destroy'), { id: row.id }, { onSuccess(page) { message.success(page.props.message) } })
</script>

<template>
    <Head title="Admin home page" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Главный страница</h2>

                <n-button type="success" ghost @click="details.showModal = true; details.body = []">
                    <template #icon>
                        <Add />
                    </template>
                </n-button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <n-data-table :columns="details.columns" :data="faqs" :bordered="true" striped />
                </div>
            </div>
        </div>

        <n-modal v-model:show="details.showModal" :close-on-esc="false" :mask-closable="false" preset="card" size="huge"
            class="max-w-[500px]">
            <template #header>
                <div class="text-center">
                    <n-tag v-if="!details.body.id" type="success">Создать новый</n-tag>
                    <n-tag v-else-if="details.type == 'view'" type="info">Просмотр</n-tag>
                    <n-tag v-else type="warning">Обновить</n-tag>
                </div>
            </template>

            <n-card :bordered="false" size="small" role="dialog" aria-modal="true">
                <n-dynamic-input v-if="!details.body.id" v-model:value="details.body" preset="pair" :min="1" :max="10"
                    @create="collapseCreate">
                    <template #create-button-default>
                        Нажмите, чтобы создать
                    </template>
                    <template #default="{ value }">
                        <div>
                            <n-input v-model:value="value.quest" type="text" placeholder="Введите вопрос" />
                            <n-input v-model:value="value.answer" type="textarea" placeholder="Введите ответ"
                                class="my-2" />
                            <n-input v-model:value="value.turn" type="text" :allow-input="onlyAllowNumber"
                                placeholder="Введите очередь" />
                        </div>
                    </template>
                </n-dynamic-input>
                <div v-else>
                    <n-input v-model:value="details.body.quest" type="text" placeholder="Введите вопрос" />
                    <n-input v-model:value="details.body.answer" type="textarea" placeholder="Введите ответ" class="my-2" />
                    <n-input v-model:value="details.body.turn" type="text" :allow-input="onlyAllowNumber"
                        placeholder="Введите очередь" />
                </div>

                <div class="flex justify-end mt-5">
                    <n-button type="error" ghost class="!mr-4" @click="details.showModal = false">Отменить</n-button>
                    <n-button type="success" :disabled="!details.body" ghost
                        @click="details.body.id ? update() : store()">{{ details.body.id ?
                            'Обновлять' : 'Добавить' }}</n-button>
                </div>
            </n-card>
        </n-modal>
    </AuthenticatedLayout>
</template>
