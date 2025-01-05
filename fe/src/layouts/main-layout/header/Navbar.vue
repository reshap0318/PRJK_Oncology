<template>
    <div class="app-navbar flex-shrink-0">
        <!--begin::Notifications-->
        <div class="app-navbar-item ms-1 ms-md-4">
            <!--begin::Menu- wrapper-->
            <div
                class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end"
                id="kt_menu_item_wow"
            >
                <KTIcon icon-name="notification-on" icon-class="fs-2" />
            </div>
            <KTNotificationMenu />
            <!--end::Menu wrapper-->
        </div>
        <!--end::Notifications-->
        <div class="app-navbar-item ms-1 ms-md-3">
            <a
                href="javascript:void(0)"
                class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
                data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end"
            >
                <KTIcon v-if="themeMode === 'light'" icon-name="night-day" icon-class="fs-2" />
                <KTIcon v-else icon-name="moon" icon-class="fs-2" />
            </a>
            <KTThemeModeSwitcher />
        </div>
        <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
            <div
                class="cursor-pointer symbol symbol-35px"
                data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-attach="parent"
                data-kt-menu-placement="bottom-end"
            >
                <img :src="authStore.avatar" class="rounded-3" alt="user" />
            </div>
            <KTUserMenu />
        </div>
        <div class="app-navbar-item d-lg-none ms-2 me-n2" v-tooltip title="Show header menu">
            <div
                class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
                id="kt_app_header_menu_toggle"
            >
                <KTIcon icon-name="element-4" icon-class="fs-2" />
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import KTUserMenu from '@/layouts/main-layout/menus/UserAccountMenu.vue'
import KTNotificationMenu from '@/layouts/main-layout/menus/NotificationsMenu.vue'
import KTThemeModeSwitcher from '@/layouts/main-layout/theme-mode/ThemeModeSwitcher.vue'

import { computed } from 'vue'
import { ThemeModeComponent } from '@/assets/ts/layout'
import { useThemeStore } from '@/stores/theme'
import { useAuthStore } from '@/stores/auth'

const store = useThemeStore()
const authStore = useAuthStore()

const themeMode = computed(() => {
    if (store.mode === 'system') {
        return ThemeModeComponent.getSystemMode()
    }
    return store.mode
})
</script>
