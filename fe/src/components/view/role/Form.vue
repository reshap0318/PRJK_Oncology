<template>
    <BaseModal modalId="default" ref="modalRef" width="mw-700px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="fv-row mb-5">
            <label class="form-label fs-6 text-dark">Name</label>
            <input
                tabindex="1"
                class="form-control"
                type="text"
                autocomplete="off"
                placeholder="name"
                v-model="formInput.name"
            />
            <form-error :err="v$.name" name="name" />
        </div>
        <div class="fv-row mb-5">
            <label class="form-label fs-6 text-dark mb-0">Permissions</label>
            <form-error :err="v$.permissions" name="permissions" class="mt-0" />
            <table class="table align-middle">
                <tbody>
                    <tr v-for="(item, key) in permissionList">
                        <th class="min-w-150px">{{ key }}</th>
                        <td class="d-flex align-items-center flex-wrap">
                            <label
                                class="form-check form-check-custom form-check-solid me-10 mt-3"
                                v-for="(checkbox, kex) in item"
                            >
                                <input
                                    class="form-check-input h-20px w-20px"
                                    type="checkbox"
                                    :value="checkbox.id"
                                    v-model="formInput.permissions"
                                />
                                <span class="form-check-label fw-semibold">
                                    {{ checkbox.value }}
                                </span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import FormError from '@/components/utils/error/FormError.vue'

import { computed, onMounted, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { useSelectStore } from '@/stores/global/select'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const modalRef = ref()
const authStore = useAuthStore()
const selectStore = useSelectStore()
const formInput = ref({
    id: 0,
    name: '',
    permissions: []
})
const rules = {
    name: { required },
    permissions: { required }
}
const v$ = useVuelidate(rules, formInput)
const title = computed(() => (formInput.value.id == 0 ? 'Create Role' : 'Edit Role'))
const permissionList = computed(() => {
    const local: any[] = []
    selectStore.permissions.forEach((elm) => {
        local.push({
            id: elm.id,
            key: elm.name.split('.')[0],
            value: elm.name.split('.')[1] ?? ''
        })
    })
    return local.reduce(function (rv, x) {
        ;(rv[x['key']] = rv[x['key']] || []).push(x)
        return rv
    }, {})
})

function show(payload = { id: 0, name: '', permissions: [] }) {
    formInput.value = payload
    modalRef.value.show()
    authStore.setFormErrorEmpty()
    v$.value.$reset()
}

function hide() {
    modalRef.value.hide()
}

function save() {
    v$.value.$validate().then((res) => {
        if (res) {
            emit('onSubmit', { form: formInput.value, editId: formInput.value.id })
        }
    })
}

onMounted(() => {
    selectStore.getPermissions()
})

defineExpose({
    show,
    hide
})
</script>
<style scoped>
.no-warp {
    width: 70% !important;
    white-space: normal;
}
</style>
