<template>
    <BaseModal modalId="create" ref="modal" width="mw-800px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Kemoterapi Lini </span>
                    </label>
                    <select class="form-control" v-model="formInput.lini">
                        <option :value="null">pilihan</option>
                        <option :value="1">1</option>
                        <option :value="2">2</option>
                        <option :value="3">3</option>
                        <option :value="4">4</option>
                        <option :value="5">5</option>
                    </select>
                    <form-error :err="v$.lini" name="lini" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Tanggal Kemoterapi </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.date" />
                    <form-error :err="v$.date" name="date" />
                </div>
            </div>
            <div class="col-12 col-sm-8 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Jenis Kemoterapi </span>
                    </label>
                    <select class="form-control" v-model="formInput.category">
                        <option :value="null">pilihan</option>
                        <option :value="1">Platinum</option>
                        <option :value="2">Kombinasi</option>
                    </select>
                    <form-error :err="v$.category" name="category" />
                </div>
            </div>
            <div class="col-12 col-sm-4 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Siklus </span>
                    </label>
                    <input
                        type="number"
                        class="form-control"
                        v-model="formInput.siklus"
                        min="0"
                        placeholder="0"
                    />
                    <form-error :err="v$.siklus" name="siklus" />
                </div>
            </div>
            <div class="col-12 mb-4" v-if="categoryDetailList.length != 0">
                <div class="d-flex align-items-center flex-wrap my-1">
                    <label
                        class="form-check form-check-custom form-check-solid me-5 mb-3"
                        v-for="item in categoryDetailList"
                        :key="item.id"
                    >
                        <input
                            multiple
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            v-model="formInput.category_detail"
                            :value="item.id"
                        />
                        <span class="form-check-label fw-semibold" v-html="item.name"> </span>
                    </label>
                </div>
                <form-error :err="v$.category_detail" name="category_detail" />
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Dosis </label>
                    <textarea
                        v-model="formInput.dose"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="Dosis"
                    ></textarea>
                    <form-error :err="v$.dose" name="dose" />
                </div>
            </div>
            <div class="col-12 mb-6">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">
                            Baseline Kemoterapi
                        </h4>
                        <div class="col-12 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark"> Subjective </label>
                                <textarea
                                    v-model="formInput.subjective"
                                    cols="30"
                                    rows="3"
                                    class="form-control"
                                    placeholder="subjective"
                                ></textarea>
                                <form-error :err="v$.subjective" name="subjective" />
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Semi Suby </span>
                                </label>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"> PS </span>
                                            </div>
                                            <input
                                                type="number"
                                                class="form-control"
                                                min="0"
                                                placeholder="0"
                                                v-model="formInput.semi_ps"
                                            />
                                        </div>
                                        <form-error :err="v$.semi_ps" name="semi_ps" />
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"> BB </span>
                                            </div>
                                            <input
                                                type="number"
                                                class="form-control"
                                                min="0"
                                                placeholder="0"
                                                v-model="formInput.semi_bb"
                                            />
                                        </div>
                                        <form-error :err="v$.semi_bb" name="semi_bb" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-8 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> WHO Toxiciti </span>
                                </label>
                                <select class="form-control" v-model="formInput.toxity">
                                    <option :value="null">pilihan</option>
                                    <option :value="1">Hematologi</option>
                                    <option :value="2">Non Hematologi</option>
                                </select>
                                <form-error :err="v$.toxity" name="toxity" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Grade </span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"> Grade </span>
                                    </div>
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="0"
                                        placeholder="0"
                                        v-model="formInput.grade"
                                    />
                                </div>
                                <form-error :err="v$.grade" name="grade" />
                            </div>
                        </div>
                        <div class="col-12 mb-4" v-if="formInput.toxity">
                            <div class="d-flex align-items-center flex-wrap">
                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer me-5 mb-3"
                                    v-for="tox in toxityList"
                                    :key="tox.id"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        :value="tox.id"
                                        v-model="formInput.toxity_detail"
                                    />
                                    <span class="form-check-label fw-semibold" v-html="tox.name">
                                    </span>
                                </label>
                            </div>
                            <form-error :err="v$.toxity_detail" name="toxity_detail" />
                        </div>
                        <div class="col-12 col-sm-6 mb-4">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Rontgen </span>
                                </label>
                                <InputFile
                                    v-model="formInput.rontgen"
                                    :accept="['.pdf', '.jpg', '.jpeg', '.png']"
                                />
                                <a
                                    v-if="fileReferral.rontgen"
                                    class="text-info"
                                    target="_blank"
                                    :href="fileReferral.rontgen"
                                    v-html="fileReferral.rontgen"
                                ></a>
                                <form-error :err="v$.rontgen" name="rontgen" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Ct-Scan </span>
                                </label>
                                <InputFile
                                    v-model="formInput.ct_scan"
                                    :accept="['.pdf', '.jpg', '.jpeg', '.png']"
                                />
                                <a
                                    v-if="fileReferral.ct_scan"
                                    class="text-info"
                                    target="_blank"
                                    :href="fileReferral.ct_scan"
                                    v-html="fileReferral.ct_scan"
                                ></a>
                                <form-error :err="v$.ct_scan" name="ct_scan" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="border-dashed" style="position: relative">
                    <div class="row px-4">
                        <h4 class="text-uppercase" style="margin-top: -10px">LABORATORIUM</h4>
                        <div class="col-12 col-sm-6">
                            <div class="fv-row mb-4">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> HB </span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="0"
                                        placeholder="0"
                                        v-model="formInput.hb"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text"> Gr % </span>
                                    </div>
                                </div>
                                <form-error :err="v$.hb" name="hb" />
                            </div>
                            <div class="fv-row mb-4">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Leukosit </span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="0"
                                        placeholder="0"
                                        v-model="formInput.leukosit"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text">/mm3 </span>
                                    </div>
                                </div>
                                <form-error :err="v$.leukosit" name="leukosit" />
                            </div>
                            <div class="fv-row mb-4">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> Trombosit </span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="0"
                                        placeholder="0"
                                        v-model="formInput.trombosit"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text">/mm3 </span>
                                    </div>
                                </div>
                                <form-error :err="v$.trombosit" name="trombosit" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="fv-row mb-4">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> SGOT </span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="0"
                                        placeholder="0"
                                        v-model="formInput.sgot"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text">U/dL </span>
                                    </div>
                                </div>
                                <form-error :err="v$.sgot" name="sgot" />
                            </div>
                            <div class="fv-row mb-4">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> SGPT </span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="0"
                                        placeholder="0"
                                        v-model="formInput.sgpt"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text">U/dL </span>
                                    </div>
                                </div>
                                <form-error :err="v$.sgpt" name="sgpt" />
                            </div>
                            <div class="fv-row mb-4">
                                <label class="form-label fs-6 text-dark">
                                    <span class="required"> CCT Urine </span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        min="0"
                                        placeholder="0"
                                        v-model="formInput.urine"
                                    />
                                    <div class="input-group-append">
                                        <span class="input-group-text"> % </span>
                                    </div>
                                </div>
                                <form-error :err="v$.urine" name="urine" />
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
                                    placeholder="0/0/0/0/0/0"
                                    v-model="formInput.dc"
                                />
                                <form-error :err="v$.dc" name="dc" />
                            </div>
                        </div>
                    </div>
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

import { computed, ref, watch } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()

const title = computed(() => (formInput.value.id == 0 ? 'Create Kemoterapi' : 'Edit Kemoterapi'))
const modal = ref()
const categoryDetailList = computed(() => {
    if (formInput.value.category == 1) {
        return [
            { id: 1, name: 'Karboplatin' },
            { id: 2, name: 'Sisplatin' }
        ]
    } else if (formInput.value.category == 2) {
        return [
            { id: 3, name: 'Paklitaksel' },
            { id: 4, name: 'Pemetreksed' },
            { id: 5, name: 'Gemsitabin' },
            { id: 6, name: 'Venorelbin' },
            { id: 7, name: 'Dosetaksel' }
        ]
    }
    return []
})
const toxityList = computed(() => {
    if (formInput.value.toxity == 1) {
        return [
            { id: 1, name: 'Anemia' },
            { id: 2, name: 'Leukositosis' },
            { id: 3, name: 'Trombositopemia' }
        ]
    } else if (formInput.value.toxity == 2) {
        return [
            { id: 4, name: 'Allopesia' },
            { id: 5, name: 'Neuropati Perifer' },
            { id: 0, name: 'Lainnya' }
        ]
    }
    return []
})

const formInput = ref({
    id: 0,
    inspection_id: 0,
    lini: null,
    category: null,
    category_detail: [],
    dose: null,
    description: null,

    date: null,
    siklus: null,
    subjective: null,
    semi_ps: null,
    semi_bb: null,
    toxity: null,
    toxity_detail: null,
    grade: null,
    rontgen: null,
    ct_scan: null,
    hb: null,
    trombosit: null,
    leukosit: null,
    sgot: null,
    sgpt: null,
    urine: null,
    dc: null,
    description_fu: null
})
const fileReferral = ref({
    rontgen: null,
    ct_scan: null
})
const rules = computed(() => {
    return {
        lini: { required },
        category: { required },
        category_detail: { required },
        dose: { required },
        description: { required },

        date: { required },
        siklus: { required },
        subjective: {}, //{ required },
        semi_ps: { required },
        semi_bb: { required },
        toxity: { required },
        toxity_detail: { required },
        grade: { required },
        rontgen: { required: requiredIf(() => fileReferral.value.rontgen == null) },
        ct_scan: { required: requiredIf(() => fileReferral.value.ct_scan == null) },
        hb: { required },
        leukosit: { required },
        trombosit: { required },
        sgot: { required },
        sgpt: { required },
        urine: { required },
        dc: { required },
        description_fu: {} //{ required }
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.inspection_id = payload.inspection_id || 0
    formInput.value.lini = payload.lini || null
    formInput.value.category = payload.category || null
    formInput.value.category_detail = payload.category_detail || []
    formInput.value.dose = payload.dose || ''
    formInput.value.description = payload.description || null

    formInput.value.date = payload.date || null
    formInput.value.siklus = payload.siklus || null
    formInput.value.subjective = payload.subjective || null
    formInput.value.semi_ps = payload.semi_ps || null
    formInput.value.semi_bb = payload.semi_bb || null
    formInput.value.toxity = payload.toxity || null
    formInput.value.toxity_detail = payload.toxity_detail || null
    formInput.value.grade = payload.grade || null
    formInput.value.hb = payload.hb || null
    formInput.value.trombosit = payload.trombosit || null
    formInput.value.leukosit = payload.leukosit || null
    formInput.value.sgot = payload.sgot || null
    formInput.value.sgpt = payload.sgpt || null
    formInput.value.urine = payload.urine || null
    formInput.value.dc = payload.dc || null
    formInput.value.description_fu = payload.description_fu || null
    formInput.value.rontgen = null
    formInput.value.ct_scan = null

    fileReferral.value.rontgen = fileRef.rontgen || null
    fileReferral.value.ct_scan = fileRef.ct_scan || null
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

watch(
    () => formInput.value.category,
    () => {
        formInput.value.category_detail = []
    }
)
</script>
