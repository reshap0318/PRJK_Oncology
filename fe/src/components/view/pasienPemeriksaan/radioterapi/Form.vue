<template>
    <BaseModal modalId="create" ref="modal" width="mw-800px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Tanggal </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.date" />
                    <form-error :err="v$.date" name="date" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Jenis Radioterapi </span>
                    </label>
                    <select class="form-control" v-model="formInput.category">
                        <option :value="null">pilihan</option>
                        <option :value="1">Radioterapi Emergensi</option>
                        <option :value="2">Radioterapi Kepala</option>
                        <option :value="3">Radioterapi Kuratif</option>
                    </select>
                    <form-error :err="v$.category" name="category" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Dosis </span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="formInput.dose"
                        placeholder="dosis"
                    />
                    <form-error :err="v$.dose" name="dose" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Fraksi </span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="formInput.fraksi"
                        placeholder="fraksi"
                    />
                    <form-error :err="v$.fraksi" name="fraksi" />
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
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Resume </label>
                    <textarea
                        v-model="formInput.description"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="resume"
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
import InputFile from '@/components/utils/form/InputFile.vue'

import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()

const title = computed(() => (formInput.value.id == 0 ? 'Create Radioterapi' : 'Edit Radioterapi'))
const modal = ref()

const formInput = ref({
    id: 0,
    inspection_id: 0,
    date: null,
    category: null,
    dose: null,
    fraksi: null,
    ct_scan: null,
    description: null
})
const ctScanReferral = ref(null)
const rules = computed(() => {
    return {
        date: { required },
        category: { required },
        dose: { required },
        fraksi: { required },
        description: { required },
        ct_scan: { required: requiredIf(() => ctScanReferral.value == null) }
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.inspection_id = payload.inspection_id || 0

    formInput.value.date = payload.date || null
    formInput.value.category = payload.category || null
    formInput.value.dose = payload.dose || null
    formInput.value.fraksi = payload.fraksi || null
    formInput.value.description = payload.description || null
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
