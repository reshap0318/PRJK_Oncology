<template>
    <div class="card card-border-outline mb-5 mb-xxl-8">
        <div class="card-header pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Change Password</span>
            </h3>
        </div>
        <div class="card-body">
            <form class="form" @submit.prevent="submit">
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">New Password</label>
                            <InputPassword v-model="formInput.password" />
                            <form-error :err="v$.password" name="password" />
                        </div>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">Confirm Password</label>
                            <InputPassword v-model="formInput.confirm_password" />
                            <form-error :err="v$.confirm_password" name="confirm_password" />
                        </div>
                    </div>
                </div>
                <div class="text-end pt-5">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script lang="ts" setup>
import FormError from '@/components/utils/error/FormError.vue'
import InputPassword from '@/components/utils/form/InputPassword.vue'

import { useProfileStore, type TChangePassword } from '@/stores/system/profile'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'

import { ref } from 'vue'

const profileStore = useProfileStore()
const formInput = ref<TChangePassword>({
    password: null,
    confirm_password: null
})
const rules = {
    password: { required },
    confirm_password: { required }
}
const v$ = useVuelidate(rules, formInput)

function submit() {
    v$.value.$validate().then((res) => {
        if (res) {
            profileStore.doChangePassword(formInput.value).then(() => {
                formInput.value.password = null
                formInput.value.confirm_password = null
                v$.value.$reset()
            })
        }
    })
}
</script>
