<template>
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <!-- https://preview.keenthemes.com/metronic8/vue/docs/#/doc-overview -->
        <button
            type="button"
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
        >
            <span class="btn-label text-uppercase">{{ appName }}</span>
            <KTIcon icon-name="document" icon-class="btn-icon fs-2 m-0" />
        </button>
    </div>
    <!--end::Footer-->
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { RouterLink } from 'vue-router'

const appName = computed(() => import.meta.env.VITE_APP_NAME)
</script>
