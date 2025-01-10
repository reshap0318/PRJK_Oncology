<template>
    <div class="row">
        <div class="col-12 col-sm-5 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class="required">Dokter</span>
                </label>
                <Multiselect
                    class="multiselect-form-control"
                    placeholder="Select dokter"
                    v-model="formInput.dokter_id"
                    :options="selectStore.dokters"
                    :searchable="true"
                />
                <form-error
                    :err="formInputValidated.overview.dokter_id"
                    name="overview.dokter_id"
                />
            </div>
        </div>
        <div class="col-12 col-sm-5 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class="required">Pasien</span>
                </label>
                <Multiselect
                    class="multiselect-form-control"
                    placeholder="Select pasien"
                    v-model="formInput.pasien_id"
                    :options="selectStore.pasiens"
                    :searchable="true"
                />
                <form-error
                    :err="formInputValidated.overview.pasien_id"
                    name="overview.pasien_id"
                />
            </div>
        </div>
        <div class="col-12 col-sm-2 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class="required">Tanggal </span>
                </label>
                <input type="date" class="form-control" v-model="formInput.tanggal" />
                <form-error :err="formInputValidated.overview.tanggal" name="overview.tanggal" />
            </div>
        </div>
        <div class="col-12" v-if="pasien.id">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Informasi Pasien</span>
            </h3>
            <div class="row">
                <div class="col-sm-6">
                    <table width="100%" class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 150px">Nama Lengkap</th>
                                <td style="width: 10px">:</td>
                                <td>
                                    {{ pasien.name }} ( <b>{{ pasien.no_mr }}</b> )
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Jenis Kelamin</th>
                                <td style="width: 10px">:</td>
                                <td>{{ pasien.gender }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Tempat Tanggal Lahir</th>
                                <td style="width: 10px">:</td>
                                <td>{{ pasien.pob + ', ' + pasien.dob }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">No Telephone</th>
                                <td style="width: 10px">:</td>
                                <td>{{ pasien.phone ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table width="100%" class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 150px">Email</th>
                                <td style="width: 10px">:</td>
                                <td>
                                    {{ pasien.email ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Pendidikan</th>
                                <td style="width: 10px">:</td>
                                <td>{{ pasien.education ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Pekerjaan</th>
                                <td style="width: 10px">:</td>
                                <td>{{ pasien.job ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 150px">Suku</th>
                                <td style="width: 10px">:</td>
                                <td>{{ pasien.ethnic ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Multiselect from '@vueform/multiselect'
import FormError from '@/components/utils/error/FormError.vue'

import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { usePasienStore } from '@/stores/module/pasien'
import { useSelectStore } from '@/stores/global/select'
import { computed, ref, watch } from 'vue'

const selectStore = useSelectStore()
const pasienStore = usePasienStore()
const pemeriksaanStore = usePasienPemeriksaanStore()
const formInput = ref(pemeriksaanStore.formInput.overview)
const formInputValidated = ref(pemeriksaanStore.formInputValidated)
const pasien = computed(() => pasienStore.itemDetail)

watch(
    () => formInput.value.pasien_id,
    (val) => {
        if (val) {
            pasienStore.getDetail(val)
        }
    }
)
</script>
