<template>
    <BaseModal modalId="createFU" ref="modal" width="mw-500px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Tanggal </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.date" />
                    <form-error :err="v$.date" name="date" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Ct-Scan </span>
                    </label>
                    <InputFile v-model="formInput.ct_scan" :accept="['.pdf']" />
                    <a
                        v-if="ctScanReferral"
                        class="text-info"
                        target="_blank"
                        :href="ctScanReferral"
                        v-html="ctScanReferral"
                    ></a>
                    <form-error :err="v$.ct_scan" name="ct_scan" />
                </div>
            </div>
        </div>
    </BaseModal>
</template>
<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import FormError from '@/components/utils/error/FormError.vue'
import InputFile from '@/components/utils/form/InputFile.vue'

import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()

const title = computed(() => (formInput.value.id == 0 ? 'Create Follow Up' : 'Edit Follow Up'))
const modal = ref()

const formInput = ref({
    id: 0,
    radio_id: 0,

    date: null,
    ct_scan: null
})
const ctScanReferral = ref(null)
const rules = computed(() => {
    return {
        date: { required },
        ct_scan: { required: requiredIf(() => ctScanReferral.value == null) }
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.radio_id = payload.radio_id || 0

    formInput.value.date = payload.date || null
    formInput.value.ct_scan = null

    ctScanReferral.value = fileRef.ct_scan || null
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
