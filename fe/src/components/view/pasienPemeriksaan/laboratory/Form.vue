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
                        <span class="required"> Hasil Laboratorium </span>
                    </label>
                    <InputFile
                        v-model="formInput.result"
                        :accept="['.pdf', '.jpg', '.jpeg', '.png']"
                    />
                    <a
                        v-if="resultReferral"
                        class="text-info"
                        target="_blank"
                        :href="resultReferral"
                        v-html="resultReferral"
                    ></a>
                    <form-error :err="v$.result" name="result" />
                </div>
            </div>
            <div class="col-12 mb-4 mt-2">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">Darah Rutin</h4>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Hb </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.hb"
                                />
                                <form-error :err="v$.hb" name="hb" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Ht </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.ht"
                                />
                                <form-error :err="v$.ht" name="ht" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Leukosit </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.leukosit"
                                />
                                <form-error :err="v$.leukosit" name="leukosit" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Tr </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.tr"
                                />
                                <form-error :err="v$.tr" name="tr" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> DC </span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="formInput.dc"
                        placeholder="0/0/0/0/0/0"
                    />
                    <form-error :err="v$.dc" name="dc" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Fungsi Hati </label>
                    <textarea
                        v-model="formInput.liver_function"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="fungsi hati"
                    ></textarea>
                    <form-error :err="v$.liver_function" name="liver_function" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Procalsitonin </label>
                    <textarea
                        v-model="formInput.procalsitonin"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="procalsitonin"
                    ></textarea>
                    <form-error :err="v$.procalsitonin" name="procalsitonin" />
                </div>
            </div>
            <div class="col-12 mb-4 mt-2">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">
                            FUNGSI GINJAL (Ur/Cr)
                        </h4>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Ur </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.ginjal_ur"
                                />
                                <form-error :err="v$.ginjal_ur" name="ginjal_ur" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Cr </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.ginjal_cr"
                                />
                                <form-error :err="v$.ginjal_cr" name="ginjal_cr" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4 mt-2">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">
                            Elektrolit (Na/K/CL)
                        </h4>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Na </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="formInput.elektrolit_na"
                                />
                                <form-error :err="v$.elektrolit_na" name="elektrolit_na" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> K </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="formInput.elektrolit_k"
                                />
                                <form-error :err="v$.elektrolit_k" name="elektrolit_k" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> CL </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="formInput.elektrolit_cl"
                                />
                                <form-error :err="v$.elektrolit_cl" name="elektrolit_cl" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4 mt-2">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">AGD</h4>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> pH </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.agd_ph"
                                />
                                <form-error :err="v$.agd_ph" name="agd_ph" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> HCO3 </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.agd_hco3"
                                />
                                <form-error :err="v$.agd_hco3" name="agd_hco3" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> PCO2 </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.agd_pco2"
                                />
                                <form-error :err="v$.agd_pco2" name="agd_pco2" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> BE </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.agd_be"
                                />
                                <form-error :err="v$.agd_be" name="agd_be" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> PO2 </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.agd_po2"
                                />
                                <form-error :err="v$.agd_po2" name="agd_po2" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> S02 </span>
                                </label>
                                <input
                                    type="number"
                                    step="0.1"
                                    class="form-control"
                                    min="0"
                                    placeholder="0,0"
                                    v-model="formInput.agd_so2"
                                />
                                <form-error :err="v$.agd_so2" name="agd_so2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> GDS </span>
                    </label>
                    <input
                        type="number"
                        step="0.1"
                        class="form-control"
                        v-model="formInput.gds"
                        placeholder="0.0"
                        min="0"
                    />
                    <form-error :err="v$.gds" name="gds" />
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
import InputFile from '@/components/utils/form/InputFile.vue'

import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'
import { convertDateToYMD } from '@/core/helpers/date'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()

const title = computed(() =>
    formInput.value.id == 0 ? 'Tambah Pemeriksaan laboratory' : 'Ubah Pemeriksaan laboratory'
)
const modal = ref()

const resultReferral = ref(null)
const formInput = ref({
    id: 0,
    inspection_id: 0,
    date: null as string | null,
    result: null,
    hb: null,
    leukosit: null,
    ht: null,
    tr: null,
    dc: null,
    liver_function: null,
    procalsitonin: null,
    ginjal_ur: null,
    ginjal_cr: null,
    elektrolit_na: null,
    elektrolit_k: null,
    elektrolit_cl: null,
    agd_ph: null,
    agd_pco2: null,
    agd_po2: null,
    agd_hco3: null,
    agd_be: null,
    agd_so2: null,
    gds: null,
    description: null
})
const rules = computed(() => {
    return {
        date: { required },
        result: { required },
        hb: { required },
        leukosit: { required },
        ht: { required },
        tr: { required },
        dc: { required },
        liver_function: { required },
        procalsitonin: { required },
        ginjal_ur: { required },
        ginjal_cr: { required },
        elektrolit_na: { required },
        elektrolit_k: { required },
        elektrolit_cl: { required },
        agd_ph: { required },
        agd_pco2: { required },
        agd_po2: { required },
        agd_hco3: { required },
        agd_be: { required },
        agd_so2: { required },
        gds: { required },
        description: {}
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.inspection_id = payload.inspection_id || 0

    formInput.value.date = convertDateToYMD(payload.date)
    formInput.value.hb = payload.hb || 0
    formInput.value.leukosit = payload.leukosit || 0
    formInput.value.ht = payload.ht || 0
    formInput.value.tr = payload.tr || 0
    formInput.value.dc = payload.dc || null
    formInput.value.liver_function = payload.liver_function || null
    formInput.value.procalsitonin = payload.procalsitonin || null
    formInput.value.ginjal_ur = payload.ginjal_ur || 0
    formInput.value.ginjal_cr = payload.ginjal_cr || 0
    formInput.value.elektrolit_na = payload.elektrolit_na || 0
    formInput.value.elektrolit_k = payload.elektrolit_k || 0
    formInput.value.elektrolit_cl = payload.elektrolit_cl || 0
    formInput.value.agd_ph = payload.agd_ph || 0
    formInput.value.agd_pco2 = payload.agd_pco2 || 0
    formInput.value.agd_po2 = payload.agd_po2 || 0
    formInput.value.agd_hco3 = payload.agd_hco3 || 0
    formInput.value.agd_be = payload.agd_be || 0
    formInput.value.agd_so2 = payload.agd_so2 || 0
    formInput.value.gds = payload.gds || 0
    formInput.value.description = payload.description || null
    formInput.value.result = null

    resultReferral.value = fileRef.result || null

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
