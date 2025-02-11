import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/pemeriksaan-bone-survey'
const base = baseStore(basePath)
export const usePemeriksaanBoneSurveyStore = defineStore('pemeriksaan-bone-survey', () => base)
