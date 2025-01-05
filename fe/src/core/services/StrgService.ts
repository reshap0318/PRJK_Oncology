const ID_TOKEN_KEY = 'token_key' as string
const ID_TOKEN_EXPIRED = 'token_expired' as string
const ID_PERMISSION_KEY = 'permission_key' as string

type TPermission = {
    id: number
    name: string
}

export const getToken = (): string | null => {
    return window.localStorage.getItem(ID_TOKEN_KEY)
}

export const saveToken = (token: string): void => {
    window.localStorage.setItem(ID_TOKEN_KEY, token)
}

export const destroyToken = (): void => {
    window.localStorage.removeItem(ID_TOKEN_KEY)
}

export const saveExpired = (second: number): void => {
    const date = new Date(new Date().getTime() + (second - 600) * 1000)
    window.localStorage.setItem(ID_TOKEN_EXPIRED, date.toString())
}

export const isExpired = (): boolean => {
    const expired = window.localStorage.getItem(ID_TOKEN_EXPIRED) as ''
    return new Date().toString() > expired
}

export const savePermission = (permissions: TPermission[]): void => {
    const payload = JSON.stringify(permissions)
    window.localStorage.setItem(ID_PERMISSION_KEY, payload)
}

export const hasPermission = (permission: string): boolean => {
    const permissions = JSON.parse(localStorage.getItem(ID_PERMISSION_KEY) as '[]') as TPermission[]
    return permissions.filter((p) => p.name == permission).length > 0
}

export const hasAnyPermission = (permission: string[]): boolean => {
    const permissions = JSON.parse(localStorage.getItem(ID_PERMISSION_KEY) as '[]') as TPermission[]
    return permissions.filter((p) => permission.includes(p.name)).length > 0
}

export default {
    getToken,
    isExpired,
    saveToken,
    saveExpired,
    destroyToken,
    savePermission,
    hasPermission,
    hasAnyPermission
}
