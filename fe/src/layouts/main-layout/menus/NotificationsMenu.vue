<template>
    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-400px" data-kt-menu="true">
        <div
            class="d-flex flex-column bgi-no-repeat rounded-top"
            :style="`background-image: url('${bgUrl}')`"
        >
            <h3 class="text-white fw-semobold px-9 mt-10 mb-6">
                Notifications
                <span class="fs-8 opacity-75 ps-3"
                    >{{ dataNotif.length + dataLogs.length }} reports</span
                >
            </h3>
            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semobold px-9">
                <li class="nav-item">
                    <a
                        class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                        data-bs-toggle="tab"
                        href="#kt_topbar_notifications_1"
                    >
                        Alerts
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                        data-bs-toggle="tab"
                        href="#kt_topbar_notifications_3"
                    >
                        Logs
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">
                    <template v-for="(item, index) in dataNotif" :key="index">
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-35px me-4">
                                    <span :class="`bg-light-${item.state}`" class="symbol-label">
                                        <KTIcon
                                            :icon-name="item.icon"
                                            :icon-class="`text-${item.state}`"
                                        />
                                    </span>
                                </div>
                                <div class="mb-0 me-2">
                                    <a
                                        href="javascript:void(0)"
                                        class="fs-6 text-gray-800 text-hover-primary fw-bold"
                                    >
                                        {{ item.title }}
                                    </a>
                                    <div class="text-gray-400 fs-7">
                                        {{ item.description }}
                                    </div>
                                </div>
                            </div>
                            <span class="badge badge-light fs-8">{{ item.time }}</span>
                        </div>
                    </template>
                </div>
                <div class="py-3 text-center border-top">
                    <a
                        href="javascript:void(0)"
                        class="btn btn-color-gray-600 btn-active-color-primary"
                    >
                        View All
                        <KTIcon icon-name="arrow-right" icon-class="fs-5" />
                    </a>
                </div>
            </div>
            <div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">
                    <template v-for="(item, index) in dataLogs" :key="index">
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center me-2">
                                <span
                                    class="w-50px badge justify-content-center me-4"
                                    :class="`badge-light-${item.state}`"
                                >
                                    {{ item.code }}
                                </span>
                                <a
                                    href="javascript::void(0)"
                                    class="text-gray-800 text-hover-primary fw-semobold"
                                >
                                    {{ item.message }}
                                </a>
                            </div>
                            <span class="badge badge-light fs-8">{{ item.time }}</span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getAssetPath } from '@/core/helpers/assets'
import { useProfileStore } from '@/stores/system/profile'
import { computed } from 'vue'

type TLog = {
    code: string
    state: string
    message: string
    time: string
}

const bgUrl = computed(() => getAssetPath('media/misc/menu-header-bg.jpg'))
const profileStore = useProfileStore()

const dataNotif = [
    {
        title: 'Project Alice',
        description: 'Phase 1 development',
        time: '1 hr',
        icon: 'technology-2',
        state: 'primary'
    },
    {
        title: 'HR Confidential',
        description: 'Confidential staff documents',
        time: '2 hrs',
        icon: 'information-5',
        state: 'danger'
    },
    {
        title: 'Company HR',
        description: 'Corporeate staff profiles',
        time: '5 hrs',
        icon: 'briefcase',
        state: 'warning'
    },
    {
        title: 'Project Redux',
        description: 'New frontend admin theme',
        time: '2 days',
        icon: 'cloud-change',
        state: 'success'
    },
    {
        title: 'Project Breafing',
        description: 'Product launch status update',
        time: '21 Jan',
        icon: 'map',
        state: 'primary'
    },
    {
        title: 'Banner Assets',
        description: 'Collection of banner images',
        time: '21 Jan',
        icon: 'graph-3',
        state: 'info'
    },
    {
        title: 'Icon Assets',
        description: 'Collection of SVG icons',
        time: '20 March',
        icon: 'color-swatch',
        state: 'warning'
    }
]

const dataLogs = computed((): TLog[] => {
    return profileStore.logs.map((l: any) => {
        let state = 'success'
        if (l.status >= 300 && l.status < 500) state = 'warning'
        else if (l.status >= 500) state = 'danger'
        return {
            code: l.status,
            state: state,
            message: l.description,
            time: l.server_time_diff
        }
    }) as TLog[]
})
</script>
