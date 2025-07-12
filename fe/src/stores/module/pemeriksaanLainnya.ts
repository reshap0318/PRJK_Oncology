import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-lainnya'
const base = baseStore(basePath)
export const usePemeriksaanLainnyaStore = defineStore('pemeriksaan-lainnya', () => base)
