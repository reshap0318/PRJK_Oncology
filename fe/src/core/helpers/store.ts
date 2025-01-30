import client from 'api-client'
import Swal from 'sweetalert2'
import { useAuthStore } from '@/stores/auth'
import { computed, ref } from 'vue'

type TBaseFunction = {
    itemList: any
    itemDetail: any
    loading: any
    getLoading: any
    datatableLink: string
    getList: (request: any, config?: any) => Promise<any>
    getDetail: (id: number | string) => Promise<any>
    create: (request: any) => Promise<any>
    update: (id: number | string, request: any) => Promise<any>
    createFile: (request: any) => Promise<any>
    updateFile: (id: number | string, request: any) => Promise<any>
    delete: (id: number | string) => Promise<any>
    actionUpSert: (data: any) => Promise<any>
    actionUpSertFile: (id: number | string) => Promise<any>
    actionDelete: (id: number | string) => Promise<any>
}

export function baseStore(basePath: string): TBaseFunction {
    const itemList = ref([])
    const itemDetail = ref({})
    const loading = ref({})

    const getLoading = computed(() => {
        return (key: string): string => loading.value[key] ?? false
    })

    async function getList(request: any = {}, config: any = {}): Promise<any> {
        itemList.value = []
        loading.value['getList'] = true
        return new Promise((resolve, reject) => {
            const param = new URLSearchParams(request).toString()
            client()
                .get(`${basePath}?${param}`, config)
                .then((res: any) => {
                    itemList.value = res.data.data
                    delete res.data.data
                    loading.value['getList'] = false
                    return resolve({
                        data: itemList.value,
                        pagination: res.data
                    })
                })
                .catch((err: any) => {
                    if (err.code != 'ERR_CANCELED') {
                        loading.value['getList'] = false
                    }
                    return reject(err)
                })
        })
    }

    async function getDetail(id: number | string): Promise<any> {
        itemDetail.value = {}
        loading.value['getDetail'] = true
        return new Promise((resolve, reject) => {
            client()
                .get(`${basePath}/${id}`)
                .then((res: any) => {
                    itemDetail.value = res.data
                    resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (loading.value['getDetail'] = false))
        })
    }

    async function create(request: any) {
        const utils = useAuthStore()
        loading.value['create'] = true
        return new Promise((resolve, reject) => {
            client()
                .post(`${basePath}`, request)
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (loading.value['create'] = false))
        })
    }

    async function update(id: number | string, request: any) {
        const utils = useAuthStore()
        loading.value['update'] = true
        return new Promise((resolve, reject) => {
            client()
                .patch(`${basePath}/${id}`, request)
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (loading.value['update'] = false))
        })
    }

    async function createFile(request: any) {
        const utils = useAuthStore()
        loading.value['create'] = true
        return new Promise((resolve, reject) => {
            client()
                .post(`${basePath}`, request, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (loading.value['create'] = false))
        })
    }

    async function updateFile(id: number | string, request: any) {
        const utils = useAuthStore()
        request._method = 'PATCH'
        loading.value['update'] = true
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
                .finally(() => (loading.value['update'] = false))
        })
    }

    async function destroy(id: number | string) {
        const utils = useAuthStore()
        loading.value['destroy'] = true
        return new Promise((resolve, reject) => {
            client()
                .delete(`${basePath}/${id}`, {})
                .then((res: any) => {
                    utils.setFormErrorEmpty()
                    return resolve(res)
                })
                .catch((err: any) => reject(err))
                .finally(() => (loading.value['destroy'] = false))
        })
    }

    async function actionUpSert(data: any) {
        return new Promise((resolve, reject) => {
            let result = new Promise((resolve) => resolve({ message: 'Success' }))
            if ([0, null, ''].includes(data.editId)) {
                result = create(data.form)
            } else {
                result = update(data.editId, data.form)
            }
            result
                .then((res: any) => {
                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success'
                    }).then(() => {
                        resolve(res)
                    })
                })
                .catch((err) => reject(err))
        })
    }

    async function actionUpSertFile(data: any) {
        return new Promise((resolve, reject) => {
            let result = new Promise((resolve) => resolve({ message: 'Success' }))
            if ([0, null, ''].includes(data.editId)) {
                delete data.form._method
                result = createFile(data.form)
            } else {
                result = updateFile(data.editId, data.form)
            }
            result
                .then((res: any) => {
                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success'
                    }).then(() => {
                        resolve(res)
                    })
                })
                .catch((err) => reject(err))
        })
    }

    async function actionDelete(id: number | string) {
        return new Promise((resolve) => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak akan dapat mengembalikannya!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true,
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id).then((res) => {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data Anda telah dihapus.',
                            icon: 'success'
                        }).then(() => {
                            resolve(res)
                        })
                    })
                }
            })
        })
    }

    return {
        datatableLink: basePath + '/datatable',
        itemList: itemList,
        itemDetail: itemDetail,
        loading: loading,
        getLoading: getLoading,
        getList: getList,
        getDetail: getDetail,
        create: create,
        update: update,
        delete: destroy,
        actionUpSert: actionUpSert,
        actionDelete: actionDelete,
        createFile: createFile,
        updateFile: updateFile,
        actionUpSertFile: actionUpSertFile,
    }
}
