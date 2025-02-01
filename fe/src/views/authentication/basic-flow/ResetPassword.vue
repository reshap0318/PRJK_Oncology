<template>
    <div class="w-lg-500px p-10">
        <form
            class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework"
            @submit.prevent="submit()"
        >
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">Reset Password</h1>
            </div>
            <div class="fv-row mb-10">
                <label class="form-label fw-bold text-gray-900 fs-6">Email</label>
                <input
                    class="form-control form-control-solid"
                    type="email"
                    placeholder=""
                    v-model="formInput.email"
                    autocomplete="off"
                    readonly
                />
                <form-error :err="v$.email" name="email" />
            </div>
            <div class="fv-row mb-10">
                <label class="form-label fw-bold text-gray-900 fs-6">New Password</label>
                <InputPassword v-model="formInput.password" />
                <form-error :err="v$.password" name="password" />
            </div>
            <div class="fv-row mb-10">
                <label class="form-label fw-bold text-gray-900 fs-6">Confirm New Password</label>
                <InputPassword v-model="formInput.password_confirmation" />
                <form-error
                    :err="v$.password_confirmation"
                    name="password_confirmation"
                    :customMessage="{
                        sameAsPassword: 'new password dan confirm password tidak sama'
                    }"
                />
            </div>
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button
                    type="submit"
                    ref="submitButton"
                    id="kt_password_reset_submit"
                    class="btn btn-lg btn-primary fw-bold me-4"
                >
                    Simpan
                </button>

                <router-link to="/sign-in" class="btn btn-lg btn-light-primary fw-bold">
                    Batal
                </router-link>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import FormError from '@/components/utils/error/FormError.vue'
import InputPassword from '@/components/utils/form/InputPassword.vue'
import Swal from 'sweetalert2'

import { onMounted, ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const formInput = ref({
    email: '',
    token: '',
    password: '',
    password_confirmation: ''
})

const rules = {
    email: {},
    password: { required },
    password_confirmation: {
        required,
        sameAsPassword: function (value: any, item: any) {
            return !value || value === item.password
        }
    }
}
const v$ = useVuelidate(rules, formInput)
const authStore = useAuthStore()

//Form submit function
function submit() {
    v$.value.$validate().then((res) => {
        if (res) {
            authStore.setFormErrorEmpty()
            Swal.fire({
                title: 'Loading',
                html: 'Checking your credentials...',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            })
            authStore
                .resetPassword(formInput.value)
                .then((res: any) => {
                    Swal.fire({
                        icon: 'info',
                        html: res.message
                    })
                })
                .finally(() => {
                    Swal.close()
                })
        }
    })
}

onMounted(() => {
    formInput.value.token = route.params.token as string
    formInput.value.email = route.query.email as string
})
</script>

<style>
body.swal2-height-auto {
    height: 100% !important;
}
</style>
