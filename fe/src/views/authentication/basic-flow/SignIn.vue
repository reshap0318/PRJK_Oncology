<template>
    <div class="w-lg-500px p-10">
        <form class="form w-100" id="kt_login_signin_form" @submit.prevent="onSubmitLogin()">
            <div class="text-center mb-10">
                <h1 class="text-dark mb-3">Sign In</h1>
                <div class="text-gray-400 fw-semobold fs-4">New Here?</div>
            </div>
            <div class="fv-row mb-10">
                <label class="form-label fs-6 fw-bold text-dark">Username / Email</label>
                <input
                    tabindex="1"
                    class="form-control form-control-lg form-control-solid"
                    type="text"
                    autocomplete="off"
                    v-model="formLogin.login"
                    placeholder="username / email"
                />
                <form-error :err="v$.login" name="login" />
            </div>
            <div class="fv-row mb-10">
                <div class="d-flex flex-stack mb-2">
                    <label class="form-label fw-bold text-dark fs-6 mb-0">Password</label>
                    <router-link to="/forgot-password" class="link-primary fs-6 fw-bold">
                        Forgot Password ?
                    </router-link>
                </div>
                <InputPassword
                    v-model="formLogin.password"
                    class-name="form-control-solid"
                    :tabindex="2"
                />
                <form-error :err="v$.password" name="password" />
            </div>
            <div class="text-center">
                <button
                    tabindex="3"
                    type="submit"
                    ref="submitButton"
                    id="kt_sign_in_submit"
                    class="btn btn-lg btn-primary w-100 mb-5"
                >
                    <span class="indicator-label"> Continue </span>
                    <span class="indicator-progress">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Wrapper-->
</template>

<script lang="ts" setup>
import Swal from 'sweetalert2'
import FormError from '@/components/utils/error/FormError.vue'
import InputPassword from '@/components/utils/form/InputPassword.vue'

import { useVuelidate } from '@vuelidate/core'
import { required, minLength } from '@vuelidate/validators'
import { ref } from 'vue'
import { useAuthStore, type LoginReq } from '@/stores/auth'
import { useRouter } from 'vue-router'

const store = useAuthStore()
const router = useRouter()

const formLogin = ref<LoginReq>({
    login: '',
    password: ''
})

const rules = {
    login: { required },
    password: { required, minLength: minLength(6) }
}
const v$ = useVuelidate(rules, formLogin)

const submitButton = ref<HTMLButtonElement | null>(null)

//Form submit function
function onSubmitLogin() {
    v$.value.$validate().then((res) => {
        if (res) {
            // Clear existing errors
            store.logout()

            if (submitButton.value) {
                submitButton.value!.disabled = true
                submitButton.value.setAttribute('data-kt-indicator', 'on')
            }
            Swal.fire({
                title: 'Loading',
                html: 'Checking your credentials...',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            })
            store
                .login(formLogin.value)
                .then(() => {
                    router.push({ name: 'home.index' })
                })
                .finally(() => {
                    Swal.close()
                })

            submitButton.value?.removeAttribute('data-kt-indicator')
            submitButton.value!.disabled = false
        }
    })
}
</script>

<style>
body.swal2-height-auto {
    height: 100% !important;
}
</style>
