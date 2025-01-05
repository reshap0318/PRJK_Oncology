<template>
    <BaseFormModal modalId="default" ref="modal" width="mw-500px" @onSubmit="save">
        <div class="fv-row mb-5">
            <label class="form-label fs-6 text-dark">TIMEZONE</label>
            <Multiselect
                class="multiselect-form-control"
                placeholder="Select frequency"
                mode="single"
                v-model="formFrequency.interval"
                :options="frequencySelect"
                :searchable="true"
                :object="false"
            />
        </div>
        <div class="fv-row mb-5" v-for="(param, idx) in paramOption" :key="idx">
            <label class="form-label fs-6 text-dark">
                {{ param.label }}<span class="text-danger">*</span>
            </label>
            <input
                class="form-control"
                :type="param.type"
                :placeholder="param.label"
                :min="param.min"
                :max="param.max"
                v-model="formFrequency['param_' + (idx + 1)]"
            />
        </div>
    </BaseFormModal>
    <div class="d-flex align-items-center justify-content-between mb-3" v-if="!readonly">
        <label class="form-label fs-6 text-dark"></label>
        <button type="button" class="btn btn-sm btn-success fs-8 fw-bold" @click="showFrequency()">
            Add FREQUENCY
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle table-hover mb-0">
            <thead>
                <tr>
                    <th style="border-top: 0px">FREQUENCY</th>
                    <th style="border-top: 0px" colspan="2">PARAMETERS</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="modelValue.length == 0">
                    <td colspan="3" class="text-center">NO FREQUENCIES FOUND</td>
                </tr>
                <tr v-else v-for="(item, i) in modelValue">
                    <td scope="row" class="py-2">{{ getLabel(item.interval) }}</td>
                    <td class="py-2">
                        {{ item.param_1 }}{{ item.param_2 ? ', ' + item.param_2 : '' }}
                    </td>
                    <td style="width: 50px" v-if="!readonly">
                        <button
                            type="button"
                            class="btn btn-icon btn-active-light-danger w-30px h-30px btn-delete"
                            @click="destroy(i)"
                        >
                            <i class="fa fa-trash" style="margin-right: 0px"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script lang="ts" setup>
import Multiselect from '@vueform/multiselect'
import BaseFormModal from '@/components/utils/modal/BaseFormModal.vue'

import { useSelectStore, type TOption } from '@/stores/global/select'
import { ref, watch } from 'vue'
import { computed } from 'vue'

type frequency = {
    interval: string | null
    param_1: string | null
    param_2: string | null
    label: string | null
}

const selectStore = useSelectStore()
const prop = defineProps({
    modelValue: {
        type: Array<frequency>,
        default: () => {
            return []
        }
    },
    readonly: {
        type: Boolean,
        default: false
    }
})
const emit = defineEmits(['update:modelValue'])
const formFrequency = ref<frequency>({
    interval: null,
    param_1: null,
    param_2: null,
    label: null
})
const modal = ref()
const frequencySelect = computed((): Array<TOption> => {
    return selectStore.schedule.frequencies.map((d: any) => {
        return {
            value: d.interval,
            label: d.label
        }
    }) as Array<TOption>
})
const paramOption = computed((): Array<any> => {
    const freq = selectStore.schedule.frequencies.find(
        (d: any) => d.interval == formFrequency.value.interval
    ) as any
    return freq?.parameters ?? []
})
const getLabel = computed(() => {
    return (input: string | null) => {
        const local = selectStore.schedule.frequencies.find((d: any) => d.interval == input) as any
        if (local) return local.label
        return 'not found'
    }
})

function showFrequency() {
    formFrequency.value = {
        interval: null,
        param_1: null,
        param_2: null,
        label: null
    }
    modal.value.show()
}

function save() {
    if (formFrequency.value.interval) {
        const newValue = [...prop.modelValue]
        const idx = newValue.findIndex((d) => d.interval == formFrequency.value.interval)
        if (idx > -1) {
            newValue[idx] = formFrequency.value
        } else {
            newValue.push(formFrequency.value)
        }
        emit('update:modelValue', newValue)
    }
    formFrequency.value = {
        interval: null,
        param_1: null,
        param_2: null,
        label: null
    }
    modal.value.hide()
}

function destroy(i: number) {
    const newValue = [...prop.modelValue]
    newValue.splice(i, 1)
    emit('update:modelValue', newValue)
}

watch(
    () => formFrequency.value.interval,
    () => {
        formFrequency.value.label = null
        formFrequency.value.param_1 = null
        formFrequency.value.param_2 = null
    }
)
</script>
