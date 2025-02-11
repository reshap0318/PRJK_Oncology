import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-toraks-usg'
const base = baseStore(basePath)
export const usePemeriksaanToraksUsgStore = defineStore('pemeriksaan-toraks-usg', () => base)
