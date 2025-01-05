import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/system/authorization/permission'
const base = baseStore(basePath)
export const usePermissionStore = defineStore('permission', () => base)
