import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-radioterapi'
const base = baseStore(basePath)
export const usePemeriksaanRadioterapiStore = defineStore('pemeriksaan-radioterapi', () => base)
