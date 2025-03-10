import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useConfigStore } from '@/stores/config'
import Swal from 'sweetalert2'

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        redirect: '/home',
        component: () => import('@/layouts/main-layout/MainLayout.vue'),
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/home',
                name: 'home.index',
                component: () => import('@/views/Home.vue'),
                meta: {
                    pageTitle: 'Home'
                }
            },
            {
                path: '/pasien',
                meta: {
                    breadcrumb: 'Pasien'
                },
                children: [
                    {
                        path: '',
                        name: 'pasien.index',
                        component: () => import('@/views/module/Pasien.vue'),
                        meta: {
                            pageTitle: 'Pasien',
                            permission: 'pasien.index'
                        }
                    },
                    {
                        path: ':id',
                        name: 'pasien.show',
                        component: () => import('@/views/module/PasienDetail.vue'),
                        meta: {
                            pageTitle: 'Detail',
                            permission: 'pasien.show',
                            breadcrumb: 'Detail'
                        }
                    }
                ]
            },
            {
                path: 'pemeriksaan',
                name: 'pemeriksaaan.index',
                component: () => import('@/views/module/Pemeriksaan.vue'),
                meta: {
                    pageTitle: 'Pemeriksaan',
                    permission: 'pasien-pemeriksaan.index'
                }
            },
            {
                path: '/profile',
                name: 'profile.index',
                redirect: {
                    name: 'profile.overview'
                },
                component: () => import('@/views/profile/Profile.vue'),
                meta: {
                    pageTitle: 'Profile',
                    breadcrumb: 'Profile'
                },
                children: [
                    {
                        path: '',
                        name: 'profile.overview',
                        component: () => import('@/views/profile/PersonalInfo.vue')
                    },
                    {
                        path: 'edit-profile',
                        name: 'profile.setting',
                        component: () => import('@/views/profile/Setting.vue'),
                        meta: {
                            pageTitle: 'Edit Profile',
                            breadcrumb: 'Edit Profile'
                        }
                    },
                    {
                        path: 'change-password',
                        name: 'profile.change-password',
                        component: () => import('@/views/profile/ChangePassword.vue'),
                        meta: {
                            pageTitle: 'Change Password',
                            breadcrumb: 'Change Password'
                        }
                    }
                ]
            },
            {
                path: '/system/user',
                name: 'user.index',
                component: () => import('@/views/system/User.vue'),
                meta: {
                    pageTitle: 'User',
                    breadcrumb: 'User',
                    permission: 'user.index'
                }
            },
            {
                path: '/system/log',
                name: 'log.index',
                component: () => import('@/views/system/LogUser.vue'),
                meta: {
                    pageTitle: 'Log',
                    breadcrumb: 'Log',
                    permission: 'log.index'
                }
            },
            {
                path: '/system/authorization/permission',
                name: 'permission.index',
                component: () => import('@/views/system/authorization/Permission.vue'),
                meta: {
                    pageTitle: 'Permission',
                    breadcrumb: 'Permission',
                    permission: 'permission.index'
                }
            },
            {
                path: '/system/authorization/role',
                name: 'role.index',
                component: () => import('@/views/system/authorization/Role.vue'),
                meta: {
                    pageTitle: 'Role',
                    breadcrumb: 'Role',
                    permission: 'role.index'
                }
            },
            {
                path: '/system/schedule',
                name: 'schedule.splitter',
                component: () => import('@/layouts/SplitterLayout.vue'),
                meta: {
                    pageTitle: 'Schedule',
                    breadcrumb: 'Schedule'
                },
                children: [
                    {
                        path: '',
                        name: 'schedule.index',
                        component: () => import('@/views/system/schedule/Schedule.vue'),
                        meta: {
                            permission: 'schedule.index'
                        }
                    },
                    {
                        path: 'create',
                        name: 'schedule.create',
                        component: () => import('@/views/system/schedule/ScheduleForm.vue'),
                        meta: {
                            pageTitle: 'Create Schedule',
                            breadcrumb: 'Create',
                            permission: 'schedule.create'
                        }
                    },
                    {
                        path: 'edit/:id',
                        name: 'schedule.edit',
                        component: () => import('@/views/system/schedule/ScheduleForm.vue'),
                        meta: {
                            pageTitle: 'Edit Schedule',
                            breadcrumb: 'Edit',
                            permission: 'schedule.edit'
                        }
                    },
                    {
                        path: ':id',
                        name: 'schedule.detail',
                        component: () => import('@/views/system/schedule/ScheduleDetail.vue'),
                        meta: {
                            pageTitle: 'Detail Schedule',
                            breadcrumb: 'Detail',
                            permission: 'schedule.show'
                        }
                    }
                ]
            }
        ]
    },
    {
        path: '/pemeriksaan/:id',
        name: 'pemeriksaaan.edit',
        component: () => import('@/views/module/PemeriksaanEdit.vue'),
        meta: {
            pageTitle: 'Pemeriksaan',
            permission: 'pasien-pemeriksaan.show'
        }
    },
    {
        path: '/',
        component: () => import('@/layouts/AuthLayout.vue'),
        meta: {
            guestOnly: true
        },
        children: [
            {
                path: '/sign-in',
                name: 'auth.login',
                component: () => import('@/views/authentication/basic-flow/SignIn.vue'),
                meta: {
                    pageTitle: 'Sign In'
                }
            },
            {
                path: '/forgot-password',
                name: 'auth.forgot-password',
                component: () => import('@/views/authentication/basic-flow/ForgotPassword.vue'),
                meta: {
                    pageTitle: 'Forgot Password'
                }
            },
            {
                path: '/password-reset/:token',
                name: 'auth.reset-password',
                component: () => import('@/views/authentication/basic-flow/ResetPassword.vue'),
                meta: {
                    pageTitle: 'Reset Password'
                }
            }
        ]
    },
    {
        path: '/',
        component: () => import('@/layouts/SystemLayout.vue'),
        children: [
            {
                // the 404 route, when none of the above matches
                path: '/404',
                name: '404',
                component: () => import('@/views/authentication/Error404.vue'),
                meta: {
                    pageTitle: 'Error 404'
                }
            },
            {
                path: '/500',
                name: '500',
                component: () => import('@/views/authentication/Error500.vue'),
                meta: {
                    pageTitle: 'Error 500'
                }
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/404'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore()
    const configStore = useConfigStore()

    // current page view title
    document.title = `${to.meta.pageTitle ?? ''} - ${import.meta.env.VITE_APP_NAME}`

    // reset config to initial state
    configStore.resetLayoutConfig()

    authStore.verifyAuth()

    // before page access check if page requires authentication
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({
            name: 'auth.login'
        })
    } else if (to.meta.guestOnly && authStore.isAuthenticated) {
        next({
            name: 'home.index'
        })
    }

    // before page access check if page requires authorization
    if (typeof to.meta.permission !== 'undefined') {
        const hasAnyAccess = authStore.hasAnyAccess([to.meta.permission as string])
        if (!hasAnyAccess) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak memiliki akses'
            })
            return next({
                name: 'home.index'
            })
        }
    }

    next()
    // Scroll page to top on every route change
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
    })
})

export default router
