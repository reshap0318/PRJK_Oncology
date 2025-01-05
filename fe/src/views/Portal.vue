<template>
    <div :style="`background-image: url(${avatarPreview})`" class="c-bg-image"></div>
    <div class="row m-2 mt-5">
        <div class="col-12 my-2 mb-6">
            <div class="card">
                <div class="card-body bg-light-success rounded">
                    <h2 class="mb-0">Selamat Datang {{ data.name }}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 my-4">
            <div
                class="rounded bg-hover-light-primary text-black cursor-pointer"
                @click="goTo('sipangka', 'home')"
            >
                <div class="d-flex flex-column align-items-center py-8">
                    <div style="height: 250px">
                        <img
                            :src="getAssetPath('images/portal/database.png')"
                            alt=""
                            height="230"
                        />
                    </div>
                    <h1 class="mt-2">SIPANGKA</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 my-4">
            <div
                class="rounded bg-hover-light-primary text-black cursor-pointer"
                @click="goTo('siami', 'home')"
            >
                <div class="d-flex flex-column align-items-center py-8">
                    <div style="height: 250px">
                        <img
                            :src="getAssetPath('images/portal/check-list.png')"
                            alt=""
                            height="250"
                        />
                    </div>
                    <h1 class="mt-2">SIAMI</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 my-4">
            <div class="rounded bg-hover-light-primary text-black cursor-pointer">
                <div class="d-flex flex-column align-items-center py-8">
                    <div style="height: 250px">
                        <img
                            :src="getAssetPath('images/portal/clipboard.png')"
                            alt=""
                            height="230"
                        />
                    </div>
                    <h1 class="mt-2">SIWORKLOAD</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6 my-4">
            <div class="rounded bg-hover-light-primary text-black cursor-pointer">
                <div class="d-flex flex-column align-items-center py-8">
                    <div style="height: 250px">
                        <img :src="getAssetPath('images/portal/folder.png')" alt="" height="230" />
                    </div>
                    <h1 class="mt-2">SIRTM</h1>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { useProfileStore } from '@/stores/system/profile'
import { computed, onBeforeMount, ref } from 'vue'
import { getAssetPath } from '@/core/helpers/assets'
import { useRouter } from 'vue-router'
import StrgService from '@/core/services/StrgService'

const profileStore = useProfileStore()
const data = computed(() => profileStore.data)
const avatarPreview = ref<string>(getAssetPath('images/backgrounds/unand1.jpg'))
const router = useRouter()
onBeforeMount(() => {
    profileStore.getProfile()
})

function goTo(kategori: string, route: string) {
    StrgService.setKategori(kategori)
    location.href = window.location.origin + '/' + route
}
</script>

<style>
.c-bg-image {
    background-image: url('/images/backgrounds/unand1.jpg') no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;

    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;

    filter: blur(4px);
    z-index: -1;

    min-height: 100%;

    /* Set up proportionate scaling */
    width: 100%;
    height: auto;

    /* Set up positioning */
    position: fixed;
    top: 0;
    left: 0;
}
</style>
