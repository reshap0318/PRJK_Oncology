<template>
    <BaseModal modalId="createFU" ref="modal" width="mw-500px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div style="margin-left: -6px">
            <table width="100%" class="table">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 150px">Tangal</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.date }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Jenis Radioterapi</th>
                        <td style="width: 10px">:</td>
                        <td>
                            {{ radio.category_text }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Dosis</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.dose }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Fraksi</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.fraksi }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">CT-Scan Baseline</th>
                        <td style="width: 10px">:</td>
                        <td>
                            <a :href="radio.ct_scan_url" target="_blank">Download</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Resume</th>
                        <td style="width: 10px">:</td>
                        <td>{{ radio.description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Tanggal FollowUp </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.date" />
                    <form-error :err="v$.date" name="date" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> CT-Scan Follow up </span>
                    </label>
                    <InputFile
                        v-model="formInput.ct_scan"
                        :accept="['.pdf', '.jpg', '.jpeg', '.png']"
                    />
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

import { usePemeriksaanRadioterapiStore } from '@/stores/module/pemeriksaanRadioterapi'
import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'
import { convertDateToYMD } from '@/core/helpers/date'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const radioStore = usePemeriksaanRadioterapiStore()
const radio = computed(() => radioStore.itemDetail)

const title = computed(() => (formInput.value.id == 0 ? 'Tambah Follow Up' : 'Ubah Follow Up'))
const modal = ref()

const formInput = ref({
    id: 0,
    radio_id: 0,

    date: null as string | null,
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

    formInput.value.date = convertDateToYMD(payload.date)
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
