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
                    <InputFile v-model="formInput.file" :accept="['.pdf']" />
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
                                    <span class="required"> Ukuran </span>
                                </label>
                                <select class="form-control" v-model="formInput.pa_size">
                                    <option :value="null">pilihan</option>
                                    <option :value="1">< 3 cm</option>
                                    <option :value="2">> 3 cm</option>
                                </select>
                                <form-error :err="v$.pa_size" name="pa_size" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Lokasi </span>
                                </label>
                                <select class="form-control" v-model="formInput.pa_lokasi">
                                    <option :value="null">pilihan</option>
                                    <option :value="1">Destruksi Iga</option>
                                    <option :value="2">Destruksi Vertebrata</option>
                                </select>
                                <form-error :err="v$.pa_lokasi" name="pa_lokasi" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Efusi Pleura </span>
                                </label>
                                <select class="form-control" v-model="formInput.pa_efusi">
                                    <option :value="null">pilihan</option>
                                    <option :value="1">Efusi Pleura</option>
                                    <option :value="2">Atelektasis</option>
                                    <option :value="3">Lainnya</option>
                                </select>
                                <form-error :err="v$.pa_efusi" name="pa_efusi" />
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark"> Keterangan </label>
                                <textarea
                                    v-model="formInput.pa_description"
                                    cols="30"
                                    rows="3"
                                    class="form-control"
                                    placeholder="keterangan"
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
                                    <span class="required"> Ukuran </span>
                                </label>
                                <select class="form-control" v-model="formInput.la_size">
                                    <option :value="null">pilihan</option>
                                    <option :value="1">< 3 cm</option>
                                    <option :value="2">> 3 cm</option>
                                </select>
                                <form-error :err="v$.la_size" name="la_size" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Lokasi </span>
                                </label>
                                <select class="form-control" v-model="formInput.la_lokasi">
                                    <option :value="null">pilihan</option>
                                    <option :value="1">Destruksi Iga</option>
                                    <option :value="2">Destruksi Vertebrata</option>
                                </select>
                                <form-error :err="v$.la_lokasi" name="la_lokasi" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Efusi Pleura </span>
                                </label>
                                <select class="form-control" v-model="formInput.la_efusi">
                                    <option :value="null">pilihan</option>
                                    <option :value="1">Efusi Pleura</option>
                                    <option :value="2">Atelektasis</option>
                                    <option :value="3">Lainnya</option>
                                </select>
                                <form-error :err="v$.la_efusi" name="la_efusi" />
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark"> Keterangan </label>
                                <textarea
                                    v-model="formInput.la_description"
                                    cols="30"
                                    rows="3"
                                    class="form-control"
                                    placeholder="keterangan"
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
    date: null,
    file: null,

    pa_size: null,
    pa_lokasi: null,
    pa_efusi: null,
    pa_efusi_lainnya: null,
    pa_description: null,

    la_size: null,
    la_lokasi: null,
    la_efusi: null,
    la_efusi_lainnya: null,
    la_description: null
})
const rules = computed(() => {
    return {
        date: { required },
        file: {},

        pa_size: { required },
        pa_lokasi: { required },
        pa_efusi: { required },
        pa_efusi_lainnya: { required: requiredIf(formInput.value.pa_efusi == null) },
        pa_description: { required },

        la_size: { required },
        la_lokasi: { required },
        la_efusi: { required },
        la_efusi_lainnya: { required: requiredIf(formInput.value.la_efusi == null) },
        la_description: { required }
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.inspection_id = payload.inspection_id || 0
    formInput.value.date = payload.date || null
    formInput.value.file = null

    formInput.value.pa_size = payload.pa_size || null
    formInput.value.pa_lokasi = payload.pa_lokasi || null
    formInput.value.pa_efusi = payload.pa_efusi || null
    formInput.value.pa_efusi_lainnya = payload.pa_efusi_lainnya || null
    formInput.value.pa_description = payload.pa_description || null

    formInput.value.la_size = payload.la_size || null
    formInput.value.la_lokasi = payload.la_lokasi || null
    formInput.value.la_efusi = payload.la_efusi || null
    formInput.value.la_efusi_lainnya = payload.la_efusi_lainnya || null
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
