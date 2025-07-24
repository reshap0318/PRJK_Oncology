<template>
    <BaseModal modalId="create" ref="modal" width="mw-800px" @onSubmit="save">
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
                        <span class="required"> Upload Hasil </span>
                    </label>
                    <InputFile
                        v-model="formInput.file"
                        :accept="['.pdf', '.jpg', '.jpeg', '.png']"
                    />
                    <a
                        v-if="fileReferral"
                        class="text-info"
                        target="_blank"
                        :href="fileReferral"
                        v-html="fileReferral"
                    ></a>
                    <form-error :err="v$.file" name="file" />
                </div>
            </div>
            <div class="col-12 mb-4 mt-2">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">PA</h4>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span> Ukuran (CM) </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.pa_size"
                                />
                                <form-error :err="v$.pa_size" name="pa_size" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span> Lokasi </span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="lokasi"
                                    v-model="formInput.pa_lokasi"
                                />
                                <form-error :err="v$.pa_lokasi" name="pa_lokasi" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span> Efusi Pleura </span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="efusi pleura"
                                    v-model="formInput.pa_efusi"
                                />
                                <form-error :err="v$.pa_efusi" name="pa_efusi" />
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    Keterangan Lainnya
                                </label>
                                <textarea
                                    v-model="formInput.pa_description"
                                    cols="30"
                                    rows="3"
                                    class="form-control"
                                    placeholder="keterangan lainnya"
                                ></textarea>
                                <form-error :err="v$.pa_description" name="pa_description" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4 mt-2">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">Lateral Kanan/Kiri</h4>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span> Ukuran (CM) </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.la_size"
                                />
                                <form-error :err="v$.la_size" name="la_size" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span> Lokasi </span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="lokasi"
                                    v-model="formInput.la_lokasi"
                                />
                                <form-error :err="v$.la_lokasi" name="la_lokasi" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span> Efusi Pleura </span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="efusi pleura"
                                    v-model="formInput.la_efusi"
                                />
                                <form-error :err="v$.la_efusi" name="la_efusi" />
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    Keterangan Lainnya
                                </label>
                                <textarea
                                    v-model="formInput.la_description"
                                    cols="30"
                                    rows="3"
                                    class="form-control"
                                    placeholder="keterangan lainnya"
                                ></textarea>
                                <form-error :err="v$.la_description" name="la_description" />
                            </div>
                        </div>
                    </div>
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
import { convertDateToYMD } from '@/core/helpers/date'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()

const title = computed(() =>
    formInput.value.id == 0 ? 'Tambah Ro. Foto Toraks' : 'Ubah Ro. Foto Toraks'
)
const modal = ref()

const fileReferral = ref(null)
const formInput = ref({
    id: 0,
    inspection_id: 0,
    date: null as string | null,
    file: null,

    pa_size: null,
    pa_lokasi: null,
    pa_efusi: null,
    pa_description: null,

    la_size: null,
    la_lokasi: null,
    la_efusi: null,
    la_description: null
})
const rules = computed(() => {
    return {
        date: { required },
        file: {},

        pa_size: {},
        pa_lokasi: {},
        pa_efusi: {},
        pa_description: {},

        la_size: {},
        la_lokasi: {},
        la_efusi: {},
        la_description: {}
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.inspection_id = payload.inspection_id || 0
    formInput.value.date = convertDateToYMD(payload.date)
    formInput.value.file = null

    formInput.value.pa_size = payload.pa_size || null
    formInput.value.pa_lokasi = payload.pa_lokasi || null
    formInput.value.pa_efusi = payload.pa_efusi || null
    formInput.value.pa_description = payload.pa_description || null

    formInput.value.la_size = payload.la_size || null
    formInput.value.la_lokasi = payload.la_lokasi || null
    formInput.value.la_efusi = payload.la_efusi || null
    formInput.value.la_description = payload.la_description || null

    fileReferral.value = fileRef.file || null

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
