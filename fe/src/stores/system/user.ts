import client from 'api-client'
import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'
import { useAuthStore } from '@/stores/auth'

const basePath = '/api/system/user'
const base = baseStore(basePath)
export const useUserStore = defineStore('user', () => {
    async function create(request: any) {
        const utils = useAuthStore()
        base.loading.value['create'] = true
        request.jenis_kelamin = parseInt(request.jenis_kelamin)
        return new Promise((resolve, reject) => {
            client()
                .post(basePath, request, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (base.loading.value['create'] = false))
        })
    }

    async function update(id: number, request: any) {
        const utils = useAuthStore()
        request._method = 'PATCH'
        base.loading.value['update'] = true
        return new Promise((resolve, reject) => {
            client()
                .post(`${basePath}/${id}`, request, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (base.loading.value['update'] = false))
        })
    }

    return {
        ...base,
        create,
        update
    }
})
