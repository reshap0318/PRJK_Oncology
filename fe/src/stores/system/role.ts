import { defineStore } from 'pinia'
import { baseStore } from '@/core/helpers/store'

const basePath = '/api/system/authorization/role'
const base = baseStore(basePath)
export const useRoleStore = defineStore('role', () => base)
