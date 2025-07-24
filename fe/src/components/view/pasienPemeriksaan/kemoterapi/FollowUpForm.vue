<template>
    <BaseModal modalId="createFU" ref="modal" width="mw-1000px" @onSubmit="save">
        <template #title> {{ title }} </template>

        <div style="margin-left: -6px">
            <table width="100%" class="table">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 200px">Lini</th>
                        <td style="width: 10px">:</td>
                        <td>{{ kemo.lini }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 200px">Kemoterapi Kombinasi</th>
                        <td style="width: 10px">:</td>
                        <td>
                            {{ kemo.combination_detail_text?.join(', ') }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 200px">Kemoterapi Platinum</th>
                        <td style="width: 10px">:</td>
                        <td>
                            {{ kemo.platinum_detail_text?.join(', ') }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 200px">Tanggal Kemoterapi</th>
                        <td style="width: 10px">:</td>
                        <td>{{ kemo.date }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 200px">Dosis</th>
                        <td style="width: 10px">:</td>
                        <td>{{ kemo.dose }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Tanggal FollowUp </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.date" />
                    <form-error :err="v$.date" name="date" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Siklus </span>
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
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Semi Suby </span>
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
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> WHO Toxiciti </span>
                    </label>
                    <select class="form-control" v-model="formInput.toxity">
                        <option :value="null">pilihan</option>
                        <option :value="1">Hematologi</option>
                        <option :value="2">Non Hematologi</option>
                    </select>
                    <form-error :err="v$.toxity" name="toxity" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Grade </span>
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
                        <span class="form-check-label fw-semibold" v-html="tox.name"> </span>
                    </label>
                </div>
                <form-error :err="v$.toxity_detail" name="toxity_detail" />
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Rontgen </span>
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
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Ct-Scan </span>
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
            <div class="col-12 col-sm-6">
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span> HB </span>
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
                        <span> Leukosit </span>
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
                        <span> Trombosit </span>
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
                        <span> SGOT </span>
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
                        <span> SGPT </span>
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
                        <span> CCT Urine </span>
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
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span> DC </span>
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
import { usePemeriksaanKemoterapiStore } from '@/stores/module/pemeriksaanKemoterapi'
import { convertDateToYMD } from '@/core/helpers/date'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const kemoterapiStore = usePemeriksaanKemoterapiStore()

const kemo = computed(() => kemoterapiStore.itemDetail)
const title = computed(() => (formInput.value.id == 0 ? 'Tambah Follow Up' : 'Ubah Follow Up'))
const modal = ref()
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
    kemo_id: 0,

    date: null as string | null,
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
        date: {},
        siklus: {},
        subjective: {}, //{ },
        semi_ps: {},
        semi_bb: {},
        toxity: {},
        toxity_detail: { required: requiredIf(() => formInput.value.toxity != null) },
        grade: {},
        rontgen: {},
        ct_scan: {},
        hb: {},
        leukosit: {},
        trombosit: {},
        sgot: {},
        sgpt: {},
        urine: {},
        dc: {},
        description_fu: {} //{  }
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.kemo_id = payload.kemo_id || 0

    formInput.value.date = null
    formInput.value.date = convertDateToYMD(payload.date)
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
</script>
