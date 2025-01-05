<template>
    <!--begin::Menu-->
    <div
        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semobold py-4 fs-6 w-275px"
        data-kt-menu="true"
    >
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img alt="Logo" :src="store.avatar" />
                </div>
                <!--end::Avatar-->

                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5">{{ first_name }}</div>
                    <a href="#" class="fw-semobold text-muted text-hover-primary fs-7">
                        {{ store.user.email }}
                    </a>
                </div>
                <!--end::Username-->
            </div>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu separator-->
        <div class="separator my-2"></div>

        <div class="menu-item px-5">
            <router-link to="/profile" class="menu-link px-5"> My Profile </router-link>
        </div>

        <div class="menu-item px-5">
            <router-link :to="{ name: 'profile.setting' }" class="menu-link px-5">
                Setting
            </router-link>
        </div>

        <div class="menu-item px-5">
            <router-link :to="{ name: 'profile.change-password' }" class="menu-link px-5">
                Change Password
            </router-link>
        </div>

        <div class="menu-item px-5">
            <a @click="signOut()" class="menu-link px-5"> Sign Out </a>
        </div>
    </div>
    <!--end::Menu-->
</template>

<script lang="ts" setup>
import { useAuthStore } from '@/stores/auth'
import { computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const store = useAuthStore()

const first_name = computed((): string => {
    return store.user.name?.split(' ')[0] ?? ''
})

const signOut = () => {
    store.logout()
    router.push({ name: 'auth.login' })
}
</script>
