import client from 'api-client'
import { defineStore } from 'pinia'

export const year = new Date().getFullYear()
export const useExportLaporanStore = defineStore('export-laporan', () => {
    async function downloadPDF(id: any) {
        return new Promise((resolve, reject) => {
            client()
                .get(`/api/export/pemeriksaan-pdf/${id}`, {
                    responseType: 'blob'
                })
                .then((res: any) => resolve(res))
                .catch((err: any) => reject(err))
        })
    }

    async function downloadExcel(request: any) {
        const param = new URLSearchParams(request).toString()
        return new Promise((resolve, reject) => {
            client()
                .get(`/api/export/pemeriksaan-excel?${param}`, {
                    responseType: 'blob'
                })
                .then((res: any) => resolve(res))
                .catch((err: any) => reject(err))
        })
    }

    return {
        downloadPDF,
        downloadExcel
    }
})
