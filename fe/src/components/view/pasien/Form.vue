<template>
    <BaseModal modalId="default" ref="modal" width="mw-800px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <div class="col-12 col-sm-9 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Nama</span>
                    </label>
                    <input
                        tabindex="1"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="nama"
                        v-model="formInput.name"
                    />
                    <form-error :err="v$.name" name="name" />
                </div>
            </div>
            <div class="col-12 col-sm-3 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">No MR</span>
                    </label>
                    <input
                        tabindex="2"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="No MR"
                        v-model="formInput.no_mr"
                    />
                    <form-error :err="v$.no_mr" name="no_mr" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Tempat Lahir</span>
                    </label>
                    <input
                        tabindex="3"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="tempat lahir"
                        v-model="formInput.pob"
                    />
                    <form-error :err="v$.pob" name="pob" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Tanggal Lahir</span>
                    </label>
                    <input
                        tabindex="4"
                        class="form-control"
                        type="date"
                        autocomplete="off"
                        placeholder="tanggal lahir"
                        v-model="formInput.dob"
                    />
                    <form-error :err="v$.dob" name="dob" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Jenis Kelamin</span>
                    </label>
                    <Multiselect
                        tabindex="5"
                        class="multiselect-form-control"
                        placeholder="Select jenis kelamin"
                        v-model="formInput.gender"
                        :options="[
                            { value: 0, label: 'Perempuan' },
                            { value: 1, label: 'Laki-laki' }
                        ]"
                    />
                    <form-error :err="v$.gender" name="gender" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Suku</label>
                    <input
                        tabindex="6"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="suku"
                        v-model="formInput.ethnic"
                    />
                    <form-error :err="v$.ethnic" name="ethnic" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Telepon</label>
                    <input
                        tabindex="7"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="telepon"
                        v-model="formInput.phone"
                    />
                    <form-error :err="v$.phone" name="phone" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Email</label>
                    <input
                        tabindex="8"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="email"
                        v-model="formInput.email"
                    />
                    <form-error :err="v$.email" name="email" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Pendidikan</label>
                    <input
                        tabindex="9"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="pendidikan"
                        v-model="formInput.education"
                    />
                    <form-error :err="v$.education" name="education" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Pekerjaan</label>
                    <input
                        tabindex="10"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="pekerjaan"
                        v-model="formInput.job"
                    />
                    <form-error :err="v$.job" name="job" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Kabupaten / Kota</label>
                    <input
                        tabindex="9"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="kabupaten / kota"
                        v-model="formInput.city"
                        v-uppercase
                    />
                    <form-error :err="v$.city" name="city" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Provinsi</label>
                    <input
                        tabindex="10"
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="provinsi"
                        v-model="formInput.province"
                        v-uppercase
                    />
                    <form-error :err="v$.province" name="province"" />
                </div>
            </div>
            <div class="col-12 col-sm-12 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Alamat</label>
                    <textarea
                        tabindex="11"
                        class="form-control"
                        autocomplete="off"
                        placeholder="alamat"
                        v-model="formInput.address"
                        cols="30"
                        rows="3"
                    ></textarea>
                    <form-error :err="v$.address" name="address" />
                </div>
            </div>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import FormError from '@/components/utils/error/FormError.vue'
import Multiselect from '@vueform/multiselect'

import { computed, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, maxLength } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const modal = ref()
const formInput = ref({
    id: 0,
    no_mr: '',
    name: '',
    gender: null,
    dob: '',
    pob: '',
    phone: '',
    email: '',
    city: '',
    province: '',
    address: '',
    education: '',
    job: '',
    ethnic: ''
})

const rules = {
    no_mr: { required, maxLength: maxLength(10) },
    name: { required },
    gender: { required },
    dob: { required },
    pob: { required },
    phone: {},
    email: {},
    city: {},
    province: {},
    address: {},
    education: {},
    job: {},
    ethnic: {}
}

const v$ = useVuelidate(rules, formInput)
const title = computed(() => (formInput.value.id == 0 ? 'Create Pasien' : 'Edit Pasien'))

function show(payload = {}) {
    formInput.value = {
        id: 0,
        no_mr: '',
        name: '',
        gender: null,
        dob: '',
        pob: '',
        phone: '',
        email: '',
        city: '',
        province: '',
        address: '',
        education: '',
        job: '',
        ethnic: '',
        ...payload
    }
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
