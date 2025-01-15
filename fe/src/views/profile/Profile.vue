<template>
    <div class="card mb-5">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-fixed position-relative">
                        <img
                            :src="profileStore.avatar"
                            alt="image"
                            style="width: 130px; height: 160px"
                        />
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center mb-2">
                                <a
                                    href="javascript:void(0)"
                                    class="text-gray-800 text-hover-primary fs-2 fw-bold me-1"
                                >
                                    {{ data.name }}
                                </a>
                                <a href="javascript:void(0)" v-if="data.is_active">
                                    <KTIcon icon-name="verify" icon-class="fs-1 text-primary" />
                                </a>
                            </div>
                            <div class="d-flex flex-wrap fw-semobold fs-6 mb-4 pe-2">
                                <a
                                    href="javascript:void(0)"
                                    class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2"
                                >
                                    <KTIcon icon-name="profile-circle" icon-class="fs-4 me-1" />
                                    {{ data.username }}
                                </a>
                                <a
                                    href="javascript:void(0)"
                                    class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2"
                                >
                                    <KTIcon icon-name="sms" icon-class="fs-4 me-1" />
                                    {{ data.email ?? '-' }}
                                </a>
                                <a
                                    href="javascript:void(0)"
                                    class="d-flex align-items-center text-gray-400 text-hover-primary mb-2"
                                >
                                    <KTIcon icon-name="whatsapp" icon-class="fs-4 me-1" />
                                    {{ data.no_telp ?? '-' }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-stack">
                        <div class="d-flex flex-column flex-grow-1 pe-8">
                            <div class="d-flex flex-wrap">
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                >
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="fs-2 fw-bold"
                                            data-kt-countup="true"
                                            :data-kt-countup-value="data.pemeriksaan_total"
                                        >
                                            {{ data.pemeriksaan_total }}
                                        </div>
                                    </div>
                                    <div class="fw-semobold fs-6 text-gray-400">Pemeriksaan</div>
                                </div>
                                <div
                                    class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                >
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="fs-2 fw-bold"
                                            data-kt-countup="true"
                                            :data-kt-countup-value="data.pasien_total"
                                        >
                                            {{ data.pasien_total }}
                                        </div>
                                    </div>
                                    <div class="fw-semobold fs-6 text-gray-400">Pasien</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex overflow-auto h-55px">
                <ul
                    class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap"
                >
                    <li class="nav-item">
                        <router-link
                            to="/profile"
                            class="nav-link text-active-primary me-6"
                            :active-class="route.name == 'profile.overview' ? 'active' : ''"
                        >
                            Overview
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text-active-primary me-6"
                            to="/profile/edit-profile"
                            :active-class="route.name == 'profile.setting' ? 'active' : ''"
                        >
                            Setting
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            class="nav-link text-active-primary me-6"
                            to="/profile/change-password"
                            :active-class="route.name == 'profile.change-password' ? 'active' : ''"
                        >
                            Change Password
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <router-view></router-view>
</template>

<script lang="ts" setup>
import { useProfileStore } from '@/stores/system/profile'
import { computed, onBeforeMount } from 'vue'
import { useRoute } from 'vue-router'

const profileStore = useProfileStore()
const route = useRoute()
const data = computed(() => profileStore.data)

onBeforeMount(() => {
    profileStore.getProfile()
})
</script>
