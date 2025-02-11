import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-mri-kepala'
const base = baseStore(basePath)
export const usePemeriksaanMriKepalaStore = defineStore('pemeriksaan-mri-kepala', () => base)
