<template>
    <!--begin::Page title-->
    <div
        v-if="pageTitleDisplay"
        :class="`page-title d-flex flex-${pageTitleDirection} justify-content-center flex-wrap me-3`"
    >
        <template v-if="pageTitle">
            <!--begin::Title-->
            <h1
                class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"
            >
                {{ pageTitle }}
            </h1>
            <!--end::Title-->

            <span
                v-if="pageTitleDirection === 'row' && pageTitleBreadcrumbDisplay"
                class="h-20px border-gray-200 border-start mx-3"
            ></span>

            <!--begin::Breadcrumb-->
            <ul
                v-if="breadcrumbs && pageTitleBreadcrumbDisplay"
                class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1"
            >
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <router-link to="/" class="text-muted text-hover-primary">Home</router-link>
                </li>
                <!--end::Item-->
                <template v-for="(item, i) in breadcrumbs" :key="i">
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <router-link
                            v-if="i != breadcrumbs.length - 1"
                            :to="item.to"
                            class="text-muted text-hover-primary"
                        >
                            {{ item.label }}
                        </router-link>
                        <span v-else class="text-muted text-hover-primary cursor-pointer">
                            {{ item.label }}
                        </span>
                    </li>
                </template>
            </ul>
            <!--end::Breadcrumb-->
        </template>
    </div>
    <div v-else class="align-items-stretch"></div>
    <!--end::Page title-->
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import {
    pageTitleBreadcrumbDisplay,
    pageTitleDirection,
    pageTitleDisplay
} from '@/core/helpers/config'
import { useRoute } from 'vue-router'

const route = useRoute()

type TBbreadcrumb = {
    to: string
    label: string
}

const pageTitle = computed(() => {
    return route.meta.pageTitle
})

const pageSubTitle = computed(() => {
    return route.meta.pageSubTitle
})

const breadcrumbs = computed((): Array<TBbreadcrumb> => {
    return route.matched
        .filter((r) => r.meta.breadcrumb)
        .map((r) => {
            return {
                to: r.path,
                label: r.meta.breadcrumb as string
            }
        })
})
</script>
