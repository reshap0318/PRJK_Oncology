import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-radioterapi-fu'
const base = baseStore(basePath)
export const usePemeriksaanRadioterapiFUStore = defineStore(
    'pemeriksaan-radioterapi-fu',
    () => base
)
