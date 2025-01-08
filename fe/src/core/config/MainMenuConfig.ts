import StrgService from '@/core/services/StrgService'
export interface MenuItem {
    heading?: string
    sectionTitle?: string
    route?: string
    pages?: Array<MenuItem>
    keenthemesIcon?: string
    bootstrapIcon?: string
    sub?: Array<MenuItem>
    permission?: boolean
}

const MainMenu: Array<MenuItem> = [
    {
        pages: [
            {
                heading: 'Home',
                route: '/home',
                keenthemesIcon: 'element-11',
                bootstrapIcon: 'bi-app-indicator'
            },
            {
                heading: 'Pasien',
                route: '/pasien',
                keenthemesIcon: 'user-square',
                bootstrapIcon: 'bi-app-indicator'
            },
            {
                heading: 'Pemeriksaan',
                route: '/pemeriksaan',
                keenthemesIcon: 'syringe',
                bootstrapIcon: 'bi-app-indicator'
            }
        ]
    },
    {
        heading: 'SYSTEM',
        route: '/system',
        pages: [
            {
                heading: 'User',
                route: '/system/user',
                keenthemesIcon: 'user',
                bootstrapIcon: 'bi-archive',
                permission: StrgService.hasPermission('user.index')
            },
            {
                sectionTitle: 'Authorization',
                route: '/authorization',
                keenthemesIcon: 'abstract-14',
                bootstrapIcon: 'bi-archive',
                permission: StrgService.hasAnyPermission(['permission.index', 'role.index']),
                sub: [
                    {
                        heading: 'permission',
                        route: '/system/authorization/permission',
                        permission: StrgService.hasPermission('permission.index')
                    },
                    {
                        heading: 'role',
                        route: '/system/authorization/role',
                        permission: StrgService.hasPermission('role.index')
                    }
                ]
            },
            {
                heading: 'Scheduler',
                route: '/system/schedule',
                keenthemesIcon: 'calendar-tick',
                bootstrapIcon: 'bi-archive',
                permission: StrgService.hasPermission('schedule.index')
            },
            {
                heading: 'Log',
                route: '/system/log',
                keenthemesIcon: 'financial-schedule',
                bootstrapIcon: 'bi-archive',
                permission: StrgService.hasPermission('log.index')
            }
        ]
    }
]

function generateMenu(payload: Array<MenuItem>): Array<MenuItem> {
    const local: Array<MenuItem> = []
    payload.forEach((d) => {
        if (typeof d.pages !== 'undefined') {
            d.pages = generateMenu(d.pages)
        }
        if (typeof d.sub !== 'undefined') {
            d.sub = generateMenu(d.sub)
        }

        if (typeof d.permission === 'undefined' || d.permission) {
            local.push(d)
        }
    })
    return local
}

const MainMenuConfig: Array<MenuItem> = generateMenu(MainMenu)

export default MainMenuConfig
