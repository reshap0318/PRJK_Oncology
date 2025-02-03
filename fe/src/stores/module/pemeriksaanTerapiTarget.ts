import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-terapi-target'
const base = baseStore(basePath)
export const usePemeriksaanTerapiTargetStore = defineStore('pemeriksaan-terapi-target', () => base)