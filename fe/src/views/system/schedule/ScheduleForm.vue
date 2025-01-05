<template>
    <div class="mb-5 mb-xl-8 card">
        <div class="card-body">
            <form @submit.prevent="submit()">
                <div class="row">
                    <div class="col-12 col-sm-11 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">Description</label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="e.g Daily Backups"
                                v-model="formInput.description"
                            />
                            <form-error :err="v$.description" name="description" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-1 mb-5">
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
                            <label class="form-label fs-6 text-dark">COMMAND</label>
                            <Multiselect
                                mode="single"
                                class="multiselect-form-control"
                                placeholder="Select Command"
                                v-model="formInput.command"
                                :options="selectStore.schedule.commands"
                                :searchable="true"
                            />
                            <form-error :err="v$.command" name="command" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">PARAMETERS</label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="e.g --type=all or name=Reinaldo"
                                v-model="formInput.parameters"
                            />
                            <form-error :err="v$.parameters" name="parameters" />
                        </div>
                    </div>
                </div>
                <div class="separator my-4"></div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">TIMEZONE</label>
                            <Multiselect
                                mode="single"
                                class="multiselect-form-control"
                                placeholder="Select Timezone"
                                v-model="formInput.timezone"
                                :options="selectStore.schedule.timezones"
                                :searchable="true"
                            />
                            <form-error :err="v$.timezone" name="timezone" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="fv-row mb-5">
                            <label class="form-label fs-6 text-dark">TYPE</label>
                            <span class="form-check form-check-custom form-check-solid mt-3">
                                <label>
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="type"
                                        value="frequency"
                                        v-model="formInput.type"
                                    />
                                    &nbsp; Frequencies
                                </label>
                                &emsp; &emsp;
                                <label>
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="type"
                                        value="expression"
                                        v-model="formInput.type"
                                    />
                                    &nbsp; Expression
                                </label>
                            </span>
                        </div>
                        <div
                            class="fv-row border border-dashed rounded p-5"
                            style="border-width: 15px"
                            v-if="formInput.type == 'frequency'"
                        >
                            <FrequencyForm v-model="formInput.frequencies" />
                        </div>
                        <div class="fv-row mb-5" v-else>
                            <label class="form-label fs-6 text-dark">CRON EXPRESSION</label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="e.g * * * * * to run this task all the time"
                                v-model="formInput.expression"
                            />
                            <form-error :err="v$.expression" name="expression" />
                        </div>
                    </div>
                </div>
                <div class="text-center pt-7">
                    <button
                        type="button"
                        class="btn btn-light me-3"
                        @click="router.push({ name: 'schedule.index' })"
                    >
                        Back
                    </button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Multiselect from '@vueform/multiselect'
import FormError from '@/components/utils/error/FormError.vue'
import FrequencyForm from '@/components/view/schedule/FrequencyForm.vue'
import Swal from 'sweetalert2'

import { useSelectStore } from '@/stores/global/select'
import { useScheduleStore } from '@/stores/system/schedule'
import { useVuelidate } from '@vuelidate/core'
import { required, requiredIf } from '@vuelidate/validators'
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const selectStore = useSelectStore()
const scheduleStore = useScheduleStore()
const formInput = ref({
    description: null,
    command: null,
    parameters: null,
    timezone: 'Asia/Jakarta',
    is_active: true,
    email: null,
    webhook: null,
    type: 'frequency',
    expression: null,
    frequencies: []
})

const rules = {
    description: { required },
    command: { required },
    parameters: {},
    timezone: { required },
    is_active: {},
    email: {},
    webhook: {},
    type: { required },
    expression: { required: requiredIf(formInput.value.type == 'expression') },
    frequencies: { required: requiredIf(formInput.value.type == 'frequency') }
}
const v$ = useVuelidate(rules, formInput)
const isEdit = computed((): boolean => route.name == 'schedule.edit')

function submit() {
    v$.value.$validate().then((res) => {
        if (res) {
            let editId = 0
            if (isEdit.value) {
                editId = parseInt(route.params.id as string)
            }
            scheduleStore.actionUpSert({ editId: editId, form: formInput.value }).then(() => {
                router.push({ name: 'schedule.index' })
            })
        }
    })
}

onMounted(() => {
    selectStore.getSchedule()

    if (isEdit.value) {
        Swal.fire({
            icon: 'info',
            title: 'waiting..',
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })
        scheduleStore.getDetail(route.params.id as string).then((res) => {
            formInput.value.command = res.data.command
            formInput.value.description = res.data.description
            formInput.value.parameters = res.data.parameters
            formInput.value.timezone = res.data.timezone
            formInput.value.is_active = res.data.is_active
            formInput.value.email = res.data.email
            formInput.value.webhook = res.data.webhook
            formInput.value.type = 'expression'
            if (res.data.frequencies.length != 0) {
                formInput.value.type = 'frequency'
            }
            formInput.value.expression = res.data.expression
            formInput.value.frequencies = res.data.frequencies
            Swal.close()
        })
    }
})
</script>
