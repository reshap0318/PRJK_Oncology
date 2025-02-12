import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-toraks-foto'
const base = baseStore(basePath)
export const usePemeriksaanToraksFotoStore = defineStore('pemeriksaan-toraks-foto', () => base)
