<template>
    <BaseModal modalId="create" ref="modal" width="mw-900px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Tanggal </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.date" />
                    <form-error :err="v$.date" name="date" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span>Dokter</span>
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="dokter"
                        v-model="formInput.dokter"
                    />
                    <form-error :err="v$.dokter" name="dokter" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Jenis Operasi </span>
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="category"
                        v-model="formInput.category"
                    />
                    <form-error :err="v$.category" name="category" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Margin </span>
                    </label>
                    <div class="d-flex align-items-center flex-wrap my-1 mt-4">
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.margin"
                                :value="1"
                            />
                            <span class="form-check-label fw-semibold"> R1 </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.margin"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> R2 </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.margin"
                                :value="3"
                            />
                            <span class="form-check-label fw-semibold"> R3 </span>
                        </label>
                    </div>
                    <form-error :err="v$.margin" name="margin" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Resume </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.description"
                        cols="30"
                        rows="3"
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

import { useSelectStore } from '@/stores/global/select'
import { computed, onMounted, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'
import { convertDateToYMD } from '@/core/helpers/date'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const selectStore = useSelectStore()

const title = computed(() => (formInput.value.id == 0 ? 'Tambah Operasi' : 'Ubah Operasi'))
const modal = ref()

const formInput = ref({
    id: 0,
    inspection_id: 0,
    dokter: null,
    date: null as string | null,
    category: '',
    margin: [],
    description: ''
})
const rules = {
    dokter: {},
    date: { required },
    category: {},
    margin: {},
    description: {} // { required }
}
const v$ = useVuelidate(rules, formInput)

function show(payload: any = {}) {
    formInput.value.id = payload.id || 0
    formInput.value.inspection_id = payload.inspection_id || 0
    formInput.value.dokter = payload.dokter || null
    formInput.value.date = convertDateToYMD(payload.date)
    formInput.value.category = payload.category || ''
    formInput.value.margin = payload.margin || []
    formInput.value.description = payload.description || ''
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

onMounted(() => {
    selectStore.getDokters().then((res: any) => {
        if (res.length == 1) formInput.value.dokter = res[0].id
    })
})
</script>
