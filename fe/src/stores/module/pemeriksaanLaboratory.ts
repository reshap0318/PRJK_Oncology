import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-laboratory'
const base = baseStore(basePath)
export const usePemeriksaanLaboratoryStore = defineStore('pemeriksaan-laboratory', () => base)
