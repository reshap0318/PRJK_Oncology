<template>
    <BaseModal modalId="default" ref="modal" width="mw-600px" @onSubmit="save">
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
            <label class="form-label fs-6 text-dark">Description</label>
            <input
                tabindex="2"
                class="form-control"
                type="text"
                autocomplete="off"
                placeholder="description"
                v-model="formInput.keterangan"
            />
            <form-error :err="v$.keterangan" name="keterangan" />
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import FormError from '@/components/utils/error/FormError.vue'

import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, minLength } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const modal = ref()
const formInput = ref({
    id: 0,
    name: '',
    keterangan: ''
})
const rules = {
    name: { required },
    keterangan: { required, minLength: minLength(6) }
}
const v$ = useVuelidate(rules, formInput)
const title = computed(() => (formInput.value.id == 0 ? 'Create Permission' : 'Edit Permission'))

function show(payload = { id: 0, name: '', keterangan: '' }) {
    formInput.value = payload
    modal.value.show()
    authStore.setFormErrorEmpty()
    v$.value.$reset()
}

function hide() {
    modal.value.hide()
}

function save() {
    v$.value.$validate().then((res) => {
        if (res) {
            emit('onSubmit', { form: formInput.value, editId: formInput.value.id })
        }
    })
}

defineExpose({
    show,
    hide
})
</script>
