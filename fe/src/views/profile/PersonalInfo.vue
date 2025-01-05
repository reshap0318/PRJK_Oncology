<template>
    <div class="card card-border-outline mb-5 mb-xxl-8">
        <div class="card-header pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Overview</span>
            </h3>
        </div>
        <div class="card-body py-0">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <table width="100%" class="table my-2">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 150px">Nama Lengkap</th>
                                <td>{{ data.name }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Email</th>
                                <td>{{ data.email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table width="100%" class="table my-2">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 150px">Username</th>
                                <td>{{ data.username }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">No Telpone</th>
                                <td>{{ data.no_telp ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { useProfileStore } from '@/stores/system/profile'
import { computed } from 'vue'

const profileStore = useProfileStore()
const data = computed(() => profileStore.data)
</script>
