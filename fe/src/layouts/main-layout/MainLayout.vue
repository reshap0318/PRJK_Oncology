<template>
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <KTHeader />
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <KTSidebar />
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <KTToolbar />
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <KTContent></KTContent>
                        </div>
                    </div>
                    <!--end::Content wrapper-->
                    <KTFooter />
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    <KTScrollTop />
</template>

<script lang="ts">
import { defineComponent, nextTick, onBeforeMount, onMounted, watch } from 'vue'
import KTHeader from '@/layouts/main-layout/header/Header.vue'
import KTSidebar from '@/layouts/main-layout/sidebar/Sidebar.vue'
import KTContent from '@/layouts/main-layout/content/Content.vue'
import KTToolbar from '@/layouts/main-layout/toolbar/Toolbar.vue'
import KTFooter from '@/layouts/main-layout/footer/Footer.vue'
import KTScrollTop from '@/layouts/main-layout/extras/ScrollTop.vue'
import { useRoute } from 'vue-router'
import { reinitializeComponents } from '@/core/plugins/keenthemes'
import LayoutService from '@/core/services/LayoutService'

import { useProfileStore } from '@/stores/system/profile'
import StrgService from '@/core/services/StrgService'

export default defineComponent({
    name: 'default-layout',
    components: {
        KTHeader,
        KTSidebar,
        KTContent,
        KTToolbar,
        KTFooter,
        KTScrollTop
    },
    setup() {
        const route = useRoute()
        const profileStore = useProfileStore()

        onBeforeMount(() => {
            LayoutService.init()
            profileStore.getLogs()

            if (typeof route.meta.catogory !== 'undefined') {
                StrgService.setKategori(route.meta.catogory as string)
            }
        })

        onMounted(() => {
            nextTick(() => {
                reinitializeComponents()
            })
        })

        watch(
            () => route.path,
            () => {
                nextTick(() => {
                    reinitializeComponents()
                })
            }
        )
    }
})
</script>
