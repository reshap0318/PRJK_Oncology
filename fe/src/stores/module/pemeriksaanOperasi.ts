import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-operasi'
const base = baseStore(basePath)
export const usePemeriksaanOperasiStore = defineStore('pemeriksaan-operasi', () => base)
