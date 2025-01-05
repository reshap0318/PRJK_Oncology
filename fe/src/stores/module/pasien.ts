import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pasien'
const base = baseStore(basePath)
export const usePasienStore = defineStore('pasien', () => base)
