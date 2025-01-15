import client from 'api-client'
import Swal from 'sweetalert2'
import { defineStore } from 'pinia'
import { getAssetPath } from '@/core/helpers/assets'
import { computed, ref } from 'vue'

export const basePath = '/api/profile'

export type TRole = {
    id: number
    name: string
}

export type TUser = {
    id: number
    username: string
    name: string
    email: string
    avatar_url: string | undefined
    no_telp: string
    alamat: string
    is_active: boolean
    pemeriksaan_total: number
    pasien_total: number
    roles: TRole[]
}

export type TReqProfile = {
    name: string | null
    username: string | null
    email: string | null
    avatar: any | null
    no_telp: string | null
    alamat: string | null
}

export type TChangePassword = {
    password: string | null
    confirm_password: string | null
}

export const useProfileStore = defineStore('profile', () => {
    const data = ref<TUser>({} as TUser)
    const logs = ref([])
    const loading = ref({})

    const avatar = computed((): string => {
        if (data.value.avatar_url) return data.value.avatar_url
        return getAssetPath('media/avatars/300-3.jpg')
    })

    async function getProfile() {
        loading.value['execute'] = true
        return new Promise((resolve, reject) => {
            client()
                .get(basePath, {})
                .then((res: any) => {
                    data.value = res.data
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (loading.value['execute'] = false))
        })
    }

    async function getLogs() {
        loading.value['logs'] = true
        return new Promise((resolve, reject) => {
            client()
                .get(`${basePath}/logs`, {})
                .then((res: any) => {
                    logs.value = res.data
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (loading.value['logs'] = false))
        })
    }

    async function doChangeProfile(request: any) {
        loading['doChangeProfile'] = true
        return new Promise((resolve, reject) => {
            request._method = 'PATCH'
            client()
                .post('/api/profile', request, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res: any) => {
                    localStorage.setItem('user', JSON.stringify(res.data))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message
                    })
                    resolve(res.data)
                })
                .catch((err) => reject(err))
                .finally(() => (loading['doChangeProfile'] = false))
        })
    }

    async function doChangePassword(request: TChangePassword) {
        loading['doChangePassword'] = true
        return new Promise((resolve, reject) => {
            client()
                .patch('/api/profile/change-password', request)
                .then((res: any) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message
                    })
                    resolve(true)
                })
                .catch((err) => reject(err))
                .finally(() => (loading['doChangePassword'] = false))
        })
    }

    return {
        data,
        loading,
        avatar,
        logs,
        getProfile,
        doChangeProfile,
        doChangePassword,
        getLogs
    }
})
