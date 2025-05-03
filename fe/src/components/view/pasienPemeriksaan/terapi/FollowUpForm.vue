<template>
    <BaseModal modalId="createFU" ref="modal" width="mw-900px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div style="margin-left: -6px">
            <table width="100%" class="table">
                <tbody>
                    <tr>
                        <th scope="row" style="width: 150px">Tangal</th>
                        <td style="width: 10px">:</td>
                        <td>{{ terapi.date }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Jenis Terapi Target</th>
                        <td style="width: 10px">:</td>
                        <td>
                            {{ terapi.category_text }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Jenis</th>
                        <td style="width: 10px">:</td>
                        <td>{{ terapi.type }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Lama (bulan)</th>
                        <td style="width: 10px">:</td>
                        <td>{{ terapi.long }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">CT-Scan Baseline</th>
                        <td style="width: 10px">:</td>
                        <td>
                            <a :href="terapi.ct_scan_url" target="_blank">{{
                                terapi.ct_scan_url
                            }}</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Efek Samping</th>
                        <td style="width: 10px">:</td>
                        <td>{{ terapi.side_effect }}</td>
                    </tr>
                    <tr>
                        <th scope="row" style="width: 150px">Resume</th>
                        <td style="width: 10px">:</td>
                        <td>{{ terapi.description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
                    <label class="form-label fs-6 text-dark"> Subjektif </label>
                    <textarea
                        v-model="formInput.subjective"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="subjektif"
                    ></textarea>
                    <form-error :err="v$.subjective" name="subjective" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Semi Subjektif </label>
                    <textarea
                        v-model="formInput.semi_subjective"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="semi subjektif"
                    ></textarea>
                    <form-error :err="v$.semi_subjective" name="semi_subjective" />
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
                        <span class="form-check-label fw-semibold" v-html="tox.name"> </span>
                    </label>
                </div>
                <form-error :err="v$.toxity_detail" name="toxity_detail" />
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Ct-Scan </span>
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
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Efek Samping </label>
                    <textarea
                        v-model="formInput.side_effect"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="efek samping"
                    ></textarea>
                    <form-error :err="v$.side_effect" name="side_effect" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> RECIST </label>
                    <textarea
                        v-model="formInput.description"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="RECIST"
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

import { usePemeriksaanTerapiTargetStore } from '@/stores/module/pemeriksaanTerapiTarget'
import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const terapiStore = usePemeriksaanTerapiTargetStore()
const terapi = computed(() => terapiStore.itemDetail)

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
    target_id: 0,

    date: null,
    subjective: null,
    semi_subjective: null,
    toxity: null,
    toxity_detail: null,
    grade: null,
    side_effect: null,
    description: null,
    ct_scan: null
})
const ctScanReferral = ref(null)
const rules = computed(() => {
    return {
        date: { required },
        toxity: { required },
        toxity_detail: { required },
        grade: { required },
        side_effect: { required },
        description: { required },
        ct_scan: { required: requiredIf(() => ctScanReferral.value == null) }
    }
})
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}, fileRef: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.target_id = payload.target_id || 0

    formInput.value.date = payload.date || null
    formInput.value.toxity = payload.toxity || null
    formInput.value.subjective = payload.subjective || null
    formInput.value.semi_subjective = payload.semi_subjective || null
    formInput.value.toxity_detail = payload.toxity_detail || null
    formInput.value.grade = payload.grade || null
    formInput.value.side_effect = payload.side_effect || null
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
