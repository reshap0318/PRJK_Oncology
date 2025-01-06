import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pasien-pemeriksaan'
const base = baseStore(basePath)
export const usePasienPemeriksaanStore = defineStore('pasien-pemeriksaan', () => base)
