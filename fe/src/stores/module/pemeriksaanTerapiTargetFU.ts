import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-terapi-target-fu'
const base = baseStore(basePath)
export const usePemeriksaanTerapiTargetFUStore = defineStore(
    'pemeriksaan-terapi-target-fu',
    () => base
)
