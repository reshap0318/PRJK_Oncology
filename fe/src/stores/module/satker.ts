import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/satker'
const base = baseStore(basePath)
export const useSatkerStore = defineStore('satker', () => base)
