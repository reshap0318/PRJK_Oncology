import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { getAssetPath } from '@/core/helpers/assets'
import client from '@/core/services/ApiService'
import StrgService from '@/core/services/StrgService'

export interface User {
    id: number
    name: string
    username: string
    email: string
    avatar_url: string
}

export interface LoginReq {
    login: string
    password: string
}

export interface Token {
    access_token: string
    expires_in: number
}

export interface Access {
    id: number
    name: string
}

export const useAuthStore = defineStore('auth', () => {
    const isAuthenticated = ref(!!StrgService.getToken())
    const formError = ref({} as object)

    const user = computed((): User => {
        const storage = localStorage.getItem('user') ?? '{}'
        return JSON.parse(storage) as User
    })

    const avatar = computed((): string => {
        if (user.value.avatar_url) return user.value.avatar_url
        return getAssetPath('media/avatars/300-3.jpg')
    })

    function setFormError(key: string, msg: string) {
        formError.value[key] = msg
    }

    function setFormErrorEmpty() {
        formError.value = {} as object
    }

    function setAuth(authUser: User) {
        isAuthenticated.value = true
        localStorage.setItem('user', JSON.stringify(authUser))
    }

    function setPermissions(payload: { id: number; name: string }[]) {
        StrgService.savePermission(payload)
    }

    function setToken(token: Token) {
        StrgService.saveExpired(token.expires_in)
        StrgService.saveToken(token.access_token)
    }

    function purgeAuth() {
        isAuthenticated.value = false
        StrgService.destroyToken()
        localStorage.clear()
    }

    function logout() {
        purgeAuth()
    }

    function hasAnyAccess(payload: Array<string>): boolean {
        return StrgService.hasAnyPermission(payload)
    }

    function hasAccess(payload: string): boolean {
        return StrgService.hasPermission(payload)
    }

    async function login(credentials: LoginReq) {
        return client()
            .post('/api/login', credentials)
            .then(({ data }) => {
                setAuth(data.user)
                setToken(data.token)
                setPermissions(data.permissions)
            })
    }

    async function forgotPassword(payload: any) {
        return new Promise((resolve, reject) => {
            client()
                .post('/api/forgot-password', payload)
                .then((res: any) => {
                    resolve(res)
                })
                .catch((err) => reject(err))
        })
    }

    async function resetPassword(payload: any) {
        return new Promise((resolve, reject) => {
            client()
                .post('/api/reset-password', payload)
                .then((res: any) => {
                    resolve(res)
                })
                .catch((err) => reject(err))
        })
    }

    function verifyAuth(bypass: boolean = false) {
        if (StrgService.isExpired() || bypass) {
            client()
                .get('api/profile/verify-token')
                .then(({ data }) => {
                    setAuth(data.user)
                    setToken(data.token)
                    if (data.permissions) setPermissions(data.permissions)
                })
                .catch(() => {
                    purgeAuth()
                })
        }
    }

    return {
        user,
        isAuthenticated,
        formError,
        avatar,
        setFormError,
        setFormErrorEmpty,
        hasAccess,
        hasAnyAccess,
        login,
        logout,
        purgeAuth,
        resetPassword,
        forgotPassword,
        verifyAuth
    }
})
