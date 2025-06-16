<template>
    <BaseModal modalId="default" ref="modal" width="mw-700px" @onSubmit="save">
        <template #title> {{ title }} </template>
        <div class="row">
            <div class="col-12 text-center mb-3">
                <div
                    class="image-input image-input-outline"
                    :style="{
                        backgroundImage: `url(${getAssetPath('/media/avatars/blank.png')})`
                    }"
                >
                    <div
                        class="image-input-wrapper w-125px h-125px"
                        :style="`background-image: url(${avatarPreview})`"
                    ></div>

                    <label
                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow edit-image"
                        data-bs-toggle="tooltip"
                        title="Change avatar"
                        @click="editAvatar"
                    >
                        <i class="bi bi-pencil-fill fs-7"></i>
                    </label>
                    <input
                        type="file"
                        accept=".png, .jpg, .jpeg"
                        class="d-none"
                        ref="fileRef"
                        @change="changeAvatar"
                    />
                </div>
            </div>
            <div class="col-12 col-sm-10 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Nama</span>
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="name"
                        v-model="formInput.name"
                    />
                    <form-error :err="v$.name" name="name" />
                </div>
            </div>
            <div class="col-12 col-sm-2 mb-5">
                <div class="d-flex align-items-center mt-12">
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            value="1"
                            v-model="formInput.is_active"
                        />
                        <span class="form-check-label fw-semibold">Active</span>
                    </label>
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Username</span>
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="username"
                        v-model="formInput.username"
                    />
                    <form-error :err="v$.username" name="username" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Roles</span>
                    </label>
                    <Multiselect
                        class="multiselect-form-control"
                        placeholder="Select roles"
                        v-model="formInput.roles"
                        :options="selectStore.roles"
                        :searchable="true"
                    />
                    <form-error :err="v$.name" name="name" />
                </div>
            </div>
            <div class="col-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Email</span>
                    </label>
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="email"
                        v-model="formInput.email"
                    />
                    <form-error :err="v$.email" name="email" />
                </div>
            </div>
            <div class="col-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">No Telp</label>
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="0822xxxxxxxx"
                        v-model="formInput.no_telp"
                    />
                    <form-error :err="v$.no_telp" name="no_telp" />
                </div>
            </div>
            <div class="col-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span :class="formInput.id == 0 ? 'required' : ''">Password</span>
                    </label>
                    <InputPassword v-model="formInput.password" />
                    <form-error :err="v$.password" name="password" />
                </div>
            </div>
            <div class="col-6 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span :class="formInput.id == 0 ? 'required' : ''">Confirm Password</span>
                    </label>
                    <InputPassword v-model="formInput.confirm_password" />
                    <form-error :err="v$.confirm_password" name="confirm_password" />
                </div>
            </div>
            <div class="col-sm-12 mb-5">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">Alamat</label>
                    <textarea
                        class="form-control"
                        autocomplete="off"
                        placeholder="alamat"
                        v-model="formInput.alamat"
                        rows="2"
                    ></textarea>
                    <form-error :err="v$.alamat" name="alamat" />
                </div>
            </div>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseFormModal.vue'
import InputPassword from '@/components/utils/form/InputPassword.vue'
import FormError from '@/components/utils/error/FormError.vue'
import Multiselect from '@vueform/multiselect'

import { getAssetPath } from '@/core/helpers/assets'
import { computed, onBeforeMount, ref } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { useAuthStore } from '@/stores/auth'
import { useSelectStore } from '@/stores/global/select'

const emit = defineEmits(['onSubmit'])
const authStore = useAuthStore()
const selectStore = useSelectStore()
const modal = ref()
const fileRef = ref()
const avatarPreview = ref<string>(getAssetPath('media/avatars/blank.png'))

const formInput = ref({
    id: 0,
    username: '',
    name: '',
    email: '',
    no_telp: '',
    password: '',
    confirm_password: '',
    alamat: '',
    avatar: null,
    is_active: true,
    roles: []
})
const rules = {
    username: { required },
    name: { required },
    email: { required, email },
    password: {},
    confirm_password: {},
    no_telp: {},
    alamat: {},
    roles: { required }
}
const v$ = useVuelidate(rules, formInput)
const title = computed(() => (formInput.value.id == 0 ? 'Create User' : 'Edit User'))

function show(
    payload = {
        id: 0,
        name: '',
        email: '',
        username: '',
        no_telp: '',
        password: '',
        confirm_password: '',
        alamat: '',
        avatar: null,
        roles: [],
        is_active: true,
        avatar_url: null
    }
) {
    formInput.value = payload
    avatarPreview.value = getAssetPath('media/avatars/blank.png')
    if (payload.avatar_url) avatarPreview.value = payload.avatar_url
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

function editAvatar() {
    fileRef.value.click()
}

function changeAvatar() {
    const file = fileRef.value.files[0]
    avatarPreview.value = URL.createObjectURL(file)
    formInput.value.avatar = file
}

defineExpose({
    show,
    hide
})

onBeforeMount(() => {
    selectStore.getRoles()
})
</script>
<style scoped>
.edit-image {
    cursor: pointer;
    position: absolute;
    transform: translate(-50%, -50%);
    left: 100%;
    top: 0;
}
</style>
