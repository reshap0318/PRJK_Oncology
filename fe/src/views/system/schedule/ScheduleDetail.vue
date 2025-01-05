<template>
    <div class="card card-flush h-lg-100" id="">
        <div class="card-header" id="">
            <div class="card-title">
                <h2>Schedule {{ scheduleStore.itemDetail.description }}</h2>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6 mb-5">
                    <div class="fv-row">
                        <label class="form-label fs-6 text-dark">Description</label>
                        <div class="form-control" readonly>
                            {{ scheduleStore.itemDetail.timezone }}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-5 mb-5">
                    <label class="form-label fs-6 text-dark">NEXT RUN</label>
                    <div class="form-control" readonly>
                        {{ scheduleStore.itemDetail.next_run ?? 'N/A' }}
                    </div>
                </div>
                <div class="col-12 col-sm-1 mb-5 mt-12">
                    <div v-html="active(scheduleStore.itemDetail.is_active)"></div>
                </div>
                <div class="col-12 col-sm-6 mb-5">
                    <div class="fv-row">
                        <label class="form-label fs-6 text-dark">COMMAND</label>
                        <div class="form-control" readonly>
                            {{ scheduleStore.itemDetail.command }}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 mb-5">
                    <div class="fv-row">
                        <label class="form-label fs-6 text-dark">PARAMETERS</label>
                        <div class="form-control" readonly>
                            {{ scheduleStore.itemDetail.parameters ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator my-4"></div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="fv-row">
                        <label class="form-label fs-6 text-dark">TIMEZONE</label>
                        <div class="form-control" readonly>
                            {{ scheduleStore.itemDetail.timezone }}
                        </div>
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
                                    :checked="isFrequency"
                                    disabled
                                />
                                &nbsp; Frequencies
                            </label>
                            &emsp; &emsp;
                            <label>
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="type"
                                    :checked="!isFrequency"
                                    disabled
                                />
                                &nbsp; Expression
                            </label>
                        </span>
                    </div>
                    <div
                        class="fv-row mb-5 border border-dashed rounded"
                        style="border-width: 15px"
                        v-if="isFrequency"
                    >
                        <FrequencyForm
                            v-model="scheduleStore.itemDetail.frequencies"
                            :readonly="true"
                        />
                    </div>
                    <div class="fv-row mb-5" v-else>
                        <label class="form-label fs-6 text-dark">CRON EXPRESSION</label>
                        <div class="form-control" readonly>
                            {{ scheduleStore.itemDetail.expression ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator mb-6"></div>
            <div class="text-center text-md-end">
                <button
                    type="button"
                    class="btn btn-danger btn-sm me-3"
                    @click="destroy()"
                    v-if="action.delete?.isCan"
                >
                    Delete
                </button>
                <button
                    type="button"
                    class="btn btn-primary btn-sm me-3"
                    @click="edit()"
                    v-if="action.edit?.isCan"
                >
                    Edit
                </button>
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click="execute()"
                    v-if="action.executed?.isCan"
                >
                    EXECUTE
                </button>
            </div>
        </div>
    </div>
    <ExecuteResult :scheduleId="scheduleId" :key="scheduleStore.getLoading('execute')" />
</template>
<script lang="ts" setup>
import Swal from 'sweetalert2'
import { active } from '@/core/helpers/datatable'
import FrequencyForm from '@/components/view/schedule/FrequencyForm.vue'
import ExecuteResult from '@/components/view/schedule/ExecuteResult.vue'

import { useScheduleStore } from '@/stores/system/schedule'
import { useSelectStore } from '@/stores/global/select'
import { onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const selectStore = useSelectStore()
const scheduleStore = useScheduleStore()
const router = useRouter()
const route = useRoute()
const scheduleId = computed((): number => parseInt(route.params.id as string))
const isFrequency = computed((): boolean => {
    return scheduleStore.itemDetail.frequencies?.length > 0
})
const action = computed(() => scheduleStore.itemDetail.action ?? {})

function edit() {
    router.push({ name: 'schedule.edit', params: { id: scheduleId.value } })
}

function destroy() {
    scheduleStore.actionDelete(scheduleId.value).then(() => {
        router.push({ name: 'schedule.index' })
    })
}

function execute() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'execute schedule will be effect to any data',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, execute it!'
    }).then((result) => {
        if (result.isConfirmed) {
            scheduleStore.execute(scheduleId.value).then(() => {
                Swal.fire({
                    title: 'Execute!',
                    text: 'Your data has been executed.',
                    icon: 'success'
                }).then(() => {
                    //   table.value.reload()
                })
            })
        }
    })
}

onMounted(() => {
    selectStore.getSchedule()
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
        Swal.close()
    })
})
</script>
