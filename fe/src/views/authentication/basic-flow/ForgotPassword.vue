<template>
    <div class="w-lg-500px p-10">
        <form
            class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework"
            @submit.prevent="submit()"
        >
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">Forgot Password ?</h1>
                <div class="text-gray-400 fw-semobold fs-4">
                    Enter your email to forgot your password.
                </div>
            </div>
            <div class="fv-row mb-10">
                <label class="form-label fw-bold text-gray-900 fs-6">Email</label>
                <input
                    class="form-control form-control-solid"
                    type="email"
                    placeholder=""
                    v-model="formInput.email"
                    autocomplete="off"
                />
                <form-error :err="v$.email" name="email" />
            </div>
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button
                    type="submit"
                    ref="submitButton"
                    id="kt_password_forgot_submit"
                    class="btn btn-lg btn-primary fw-bold me-4"
                >
                    Submit
                </button>

                <router-link to="/sign-in" class="btn btn-lg btn-light-primary fw-bold">
                    Cancel
                </router-link>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import FormError from '@/components/utils/error/FormError.vue'
import Swal from 'sweetalert2'

import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'

const formInput = ref({
    email: ''
})

const rules = {
    email: { required, email }
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
                .forgotPassword(formInput.value)
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
</script>

<style>
body.swal2-height-auto {
    height: 100% !important;
}
</style>
