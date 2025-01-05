import client from 'api-client'
import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'
import { computed } from 'vue'

const basePath = '/api/system/schedule'
const base = baseStore(basePath)
export const useScheduleStore = defineStore('schedule', () => {
    const resultDatatableLink = computed(() => {
        return (id: string | number) => basePath + '/' + id + '/result'
    })

    async function execute(id: number) {
        base.loading.value['execute'] = true
        return new Promise((resolve, reject) => {
            client()
                .post(`${basePath}/${id}/execute`, {})
                .then((res: any) => {
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (base.loading.value['execute'] = false))
        })
    }

    return {
        ...base,
        resultDatatableLink: resultDatatableLink,
        execute: execute
    }
})
