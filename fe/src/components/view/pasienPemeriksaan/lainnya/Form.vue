<template>
    <BaseModal modalId="create" ref="modal" width="mw-800px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <!-- <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Tanggal </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.date" />
                    <form-error :err="v$.date" name="date" />
                </div>
            </div> -->
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Nama Pemeriksa </span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="formInput.inspector_name"
                        placeholder="nama pemeriksa"
                    />
                    <form-error :err="v$.inspector_name" name="inspector_name" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Hasil pemeriksaan </span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="formInput.result"
                        placeholder="hasil pemeriksaan"
                    />
                    <form-error :err="v$.result" name="result" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Keterangan </label>
                    <textarea
                        v-model="formInput.description"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="keterangan"
                    ></textarea>
                    <form-error :err="v$.description" name="description" />
                </div>
            </div>
        </div>
    </BaseModal>
</template>
<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import FormError from '@/components/utils/error/FormError.vue'

import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()

const title = computed(() =>
    formInput.value.id == 0 ? 'Tambah Pemeriksaan Lainnya' : 'Ubah Pemeriksaan Lainnya'
)
const modal = ref()

const formInput = ref({
    id: 0,
    inspection_id: 0,
    // date: null,
    inspector_name: null,
    result: null,
    description: null
})
const rules = computed(() => {
    return {
        // date: { required },
        inspector_name: { required },
        result: { required },
        description: { required }
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.inspection_id = payload.inspection_id || 0

    // formInput.value.date = payload.date || null
    formInput.value.inspector_name = payload.inspector_name || null
    formInput.value.result = payload.result || null
    formInput.value.description = payload.description || null

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
