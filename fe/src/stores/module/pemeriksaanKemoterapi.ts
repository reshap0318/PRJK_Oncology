import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-kemoterapi'
const base = baseStore(basePath)
export const usePemeriksaanKemoterapiStore = defineStore('pemeriksaan-kemoterapi', () => base)
