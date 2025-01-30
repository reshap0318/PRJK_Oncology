import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-kemoterapi-fu'
const base = baseStore(basePath)
export const usePemeriksaanKemoterapiFUStore = defineStore('pemeriksaan-kemoterapi-fu', () => base)
