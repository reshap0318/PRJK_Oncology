import client from 'api-client'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export type TSelect = {
    id: number
    name: string
}

export type TOption = {
    value: string | number
    label: string
}

export const useSelectStore = defineStore('select', () => {
    const permissions = ref<TSelect[]>([])
    const roles = ref<TOption[]>([])
    const dokters = ref<TOption[]>([])
    const pasiens = ref<TOption[]>([])
    const schedule = ref({
        timezones: [] as string[],
        frequencies: [],
        commands: {} as any
    })

    async function getPermissions() {
        return new Promise((resolve) => {
            client()
                .get('/api/select-data/permission')
                .then((res) => {
                    permissions.value = res.data
                    return resolve(res.data)
                })
        })
    }

    async function getRoles() {
        return new Promise((resolve) => {
            client()
                .get('/api/select-data/role')
                .then((res) => {
                    roles.value = res.data.map((d: any) => {
                        return { value: d.id, label: d.name }
                    })
                    return resolve(res.data)
                })
        })
    }

    async function getSchedule() {
        return new Promise((resolve) => {
            client()
                .get('/api/select-data/schedule')
                .then((res) => {
                    schedule.value = res.data
                    return resolve(res.data)
                })
        })
    }

    async function getDokters() {
        return new Promise((resolve) => {
            client()
                .get('/api/select-data/dokter')
                .then((res) => {
                    dokters.value = res.data.map((d: any) => {
                        return { value: d.id, label: d.name }
                    })
                    return resolve(res.data)
                })
        })
    }

    async function getPasiens() {
        return new Promise((resolve) => {
            client()
                .get('/api/select-data/pasien')
                .then((res) => {
                    pasiens.value = res.data.map((d: any) => {
                        return { value: d.id, label: d.name }
                    })
                    return resolve(res.data)
                })
        })
    }

    return {
        roles,
        permissions,
        schedule,
        dokters,
        pasiens,
        getRoles,
        getPermissions,
        getSchedule,
        getDokters,
        getPasiens
    }
})
