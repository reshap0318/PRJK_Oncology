<template>
    <div class="card mb-5 mb-xxl-8">
        <div class="card-header pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Edit Profile</span>
            </h3>
        </div>
        <div class="card-body">
            <form class="form" @submit.prevent="submit">
                <div class="row">
                    <div class="col-12 text-center mb-8">
                        <div
                            class="image-input image-input-outline"
                            :style="{
                                backgroundImage: `url(${getAssetPath('/media/avatars/blank.png')})`
                            }"
                        >
                            <div
                                class="image-input-wrapper w-125px h-125px"
                                :style="`background-image: url(${avatarPreview})`"
                            ></div>

                            <label
                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow edit-image"
                                data-bs-toggle="tooltip"
                                title="Change avatar"
                                @click="editAvatar"
                            >
                                <i class="bi bi-pencil-fill fs-7"></i>
                            </label>
                            <input
                                type="file"
                                accept=".png, .jpg, .jpeg"
                                class="d-none"
                                ref="fileRef"
                                @change="changeAvatar"
                            />
                        </div>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">Name</label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="name"
                                v-model="formInput.name"
                            />
                            <form-error :err="v$.name" name="name" />
                        </div>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">Username</label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="username"
                                v-model="formInput.username"
                            />
                            <form-error :err="v$.username" name="username" />
                        </div>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">Email</label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="email"
                                v-model="formInput.email"
                            />
                            <form-error :err="v$.email" name="email" />
                        </div>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">No Telp</label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="no_telp"
                                v-model="formInput.no_telp"
                            />
                            <form-error :err="v$.no_telp" name="no_telp" />
                        </div>
                    </div>
                    <div class="col-sm-12 mb-5">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">Alamat</label>
                            <textarea
                                class="form-control"
                                autocomplete="off"
                                placeholder="alamat"
                                v-model="formInput.alamat"
                                rows="2"
                            ></textarea>
                            <form-error :err="v$.alamat" name="alamat" />
                        </div>
                    </div>
                </div>
                <div class="text-end pt-5">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script lang="ts" setup>
import FormError from '@/components/utils/error/FormError.vue'
import { getAssetPath } from '@/core/helpers/assets'
import { onMounted, ref, watch } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import { useProfileStore, type TReqProfile, type TUser } from '@/stores/system/profile'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const router = useRouter()
const profileStore = useProfileStore()
const authStore = useAuthStore()
const formInput = ref<TReqProfile>({
    name: null,
    email: null,
    username: null,
    avatar: null,
    no_telp: null,
    alamat: null
})
const rules = {
    name: { required },
    email: { required, email },
    username: { required },
    avatar: {},
    alamat: {},
    no_telp: {}
}
const v$ = useVuelidate(rules, formInput)
const avatarPreview = ref<string>()
const fileRef = ref()

function submit() {
    v$.value.$validate().then((res) => {
        if (res) {
            profileStore.doChangeProfile(formInput.value).then(() => {
                authStore.verifyAuth(true)
                router.push({ name: 'profile.index' })
            })
        }
    })
}

function setForm(user: TUser) {
    formInput.value.name = user.name
    formInput.value.email = user.email
    formInput.value.username = user.username
    formInput.value.alamat = user.alamat
    formInput.value.no_telp = user.no_telp

    avatarPreview.value = user.avatar_url
}

function editAvatar() {
    fileRef.value.click()
}

function changeAvatar() {
    const file = fileRef.value.files[0]
    avatarPreview.value = URL.createObjectURL(file)
    formInput.value.avatar = file
}

onMounted(() => {
    setForm(profileStore.data)
})

watch(
    () => profileStore.data,
    (val) => {
        setForm(val)
    }
)
</script>

<style scoped>
.edit-image {
    cursor: pointer;
    position: absolute;
    transform: translate(-50%, -50%);
    left: 100%;
    top: 0;
}
</style>
