import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-toraks-scan'
const base = baseStore(basePath)
export const usePemeriksaanToraksScanStore = defineStore('pemeriksaan-toraks-scan', () => base)
