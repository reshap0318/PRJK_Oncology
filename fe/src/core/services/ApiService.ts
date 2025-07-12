declare module 'axios' {
    interface AxiosRequestConfig {
        cancelPreviousRequests?: boolean
    }
}

import axios from 'axios'
import Swal from 'sweetalert2'
import StrgService from '@/core/services/StrgService'
import { useAuthStore } from '@/stores/auth'

const usePeformance = import.meta.env.VITE_PEFORMANCE == 'true'

const requestTime = {} as any

const pendingRequests: { [key: string]: AbortController } = {}
const removePendingRequest = (url: string | undefined, abort = false): void => {
    if (url && pendingRequests[url]) {
        if (abort) {
            pendingRequests[url].abort()
        }
        delete pendingRequests[url]
    }
}
const checkPeformance = (key: string): void => {
    if (requestTime[key] && usePeformance) {
        requestTime[key] = performance.now() - requestTime[key]
        console.log(`Response '${key}' time: ${requestTime[key]} milliseconds`)
    }
}

const client = () => {
    const baseURL: string = import.meta.env.VITE_APP_API_URL
    const instance = axios.create({
        baseURL: baseURL,
        withCredentials: true,
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Credentials': true
        }
    })

    // handle response data
    instance.interceptors.response.use(
        function (response) {
            const reqKey = `[${response.config.method}]${response.config.url}`
            checkPeformance(reqKey)
            let data = response.data
            return Promise.resolve(data)
        },
        function (error) {
            if (error.response) {
                const reqKey = `[${error.config.method}]${error.config.url}`
                checkPeformance(reqKey)

                const authStore = useAuthStore()

                if (
                    error.request.responseType === 'blob' &&
                    error.response.data instanceof Blob &&
                    error.response.data.type &&
                    error.response.data.type.toLowerCase().indexOf('json') != -1
                ) {
                    error.response.data.text().then((res: any) => {
                        const t = JSON.parse(res)
                        Swal.fire({
                            title: 'Warning',
                            text: t.message,
                            icon: 'warning'
                        })
                    })
                } else if (error.response.status === 400) {
                    Swal.fire({
                        title: 'Warning',
                        text: error.response.data.message,
                        icon: 'warning'
                    })
                } else if (error.response.status === 401) {
                    Swal.fire({
                        title: 'Logout',
                        icon: 'warning'
                    }).then(() => {
                        authStore.purgeAuth()
                        location.reload()
                    })
                } else if (error.response.status === 403) {
                    Swal.fire({
                        title: 'Forbidden',
                        text: 'Tidak Memiliki Akses Kesini',
                        icon: 'warning'
                    })
                } else if (error.response.status === 422) {
                    const errors = error.response.data.errors
                    Object.keys(errors).forEach(function (key: string) {
                        errors[key].forEach((err: string) => {
                            authStore.setFormError(`${key}`, err)
                        })
                    })
                } else if (error.response.status === 500) {
                    Swal.fire({
                        title: 'internal server error',
                        text: error.response.data.message,
                        icon: 'error'
                    })
                }
            }
            // all error kecuali canceled
            else if (error.code != 'ERR_CANCELED') {
                Swal.fire({
                    title: 'internal server error',
                    text: error.response?.data?.message ?? null,
                    icon: 'error'
                })
            }
            return Promise.reject(error)
        }
    )

    // handle request data
    instance.interceptors.request.use(
        function (config) {
            // set signal
            if (config.cancelPreviousRequests && config.url && !config.signal) {
                const onlyUrl = config.url.split('?')[0]
                removePendingRequest(onlyUrl, true)
                const abortController = new AbortController()
                config.signal = abortController.signal
                pendingRequests[onlyUrl] = abortController
            }

            requestTime[`[${config.method}]${config.url}`] = performance.now()

            const token = StrgService.getToken()
            if (token && !config.headers.Authorization)
                config.headers.set('Authorization', `Bearer ${token}`)

            return config
        },
        function (error) {
            return Promise.reject(error)
        }
    )

    return instance
}

export default client
