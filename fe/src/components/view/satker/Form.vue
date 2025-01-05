<template>
    <BaseModal modalId="default" ref="modal" width="mw-600px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <div class="col-sm-12 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Nama</label>
                    <input
                        tabindex="1"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="nama"
                        v-model="formInput.name"
                    />
                    <form-error :err="v$.name" name="name" />
                </div>
            </div>
            <div class="col-sm-12 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Parent</label>
                    <Multiselect
                        tabindex="2"
                        class="multiselect-form-control"
                        placeholder="select parent"
                        v-model="formInput.parent_id"
                        :options="selectStore.satkers"
                        :searchable="true"
                    />
                    <form-error :err="v$.parent_id" name="parent_id" />
                </div>
            </div>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import FormError from '@/components/utils/error/FormError.vue'
import Multiselect from '@vueform/multiselect'
import InputFile from '@/components/utils/form/InputFile.vue'

import { computed, onMounted, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'
import { useSelectStore } from '@/stores/global/select'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const selectStore = useSelectStore()
const modal = ref()
const formInput = ref({
    id: 0,
    name: '',
    parent_id: 0
})
const rules = {
    name: { required },
    parent_id: { required }
}
const v$ = useVuelidate(rules, formInput)
const title = computed(() => (formInput.value.id == 0 ? 'Create Satker' : 'Edit Satker'))

function show(payload: any = {}, urlPayload: any = {}) {
    formInput.value.id = payload.id ?? 0
    formInput.value.name = payload.name ?? ''
    formInput.value.parent_id = payload.parent_id ?? 0

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

onMounted(() => {
    selectStore.getSatker()
})

defineExpose({
    show,
    hide
})
</script>
