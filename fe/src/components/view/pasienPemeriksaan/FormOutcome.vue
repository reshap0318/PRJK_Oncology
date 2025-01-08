<template>
    <div class="border-dashed p-4 mb-4" style="position: relative">
        <h2 class="text-uppercase">Outcome Pasien</h2>
        <div class="row">
            <div class="col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Keadaan Pulang </span>
                    </label>
                    <select v-model="formInput.keadaan_pulang" class="form-control">
                        <option value="">Status Keadaan Pulang</option>
                        <option value="1">Perbaikan</option>
                        <option value="2">Menetap</option>
                        <option value="3">Perburukan</option>
                        <option value="4">Meninggal Sebelum 48 Jam</option>
                        <option value="5">Meninggal Sesudah 48 Jam</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Cara Pulang </span>
                    </label>
                    <select v-model="formInput.cara_pulang" class="form-control">
                        <option value="">Cara Pulang</option>
                        <option value="1">Atas Persetujuan</option>
                        <option value="2">Pulang Paksa</option>
                        <option value="3">Pindah RS Lain</option>
                        <option value="4">Lari</option>
                        <option value="5">Meninggal Dunia</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Lama Dirawat </span>
                    </label>
                    <div class="input-group mb-3">
                        <input
                            type="number"
                            class="form-control"
                            min="0"
                            v-model="formInput.lama_dirawat"
                        />
                        <div class="input-group-append">
                            <span class="input-group-text"> Hari </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Tanggal Meninggal </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.tanggal_meninggal" />
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Waktu Meninggal </span>
                    </label>
                    <div class="d-flex align-items-center mt-3">
                        <label
                            class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                        >
                            <input
                                class="form-check-input"
                                type="radio"
                                :value="1"
                                v-model="formInput.waktu_meninggal"
                            />
                            <span class="form-check-label fw-semibold text-gray-500">
                                Sebelum 48 Jam
                            </span>
                        </label>

                        <label
                            class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                        >
                            <input
                                class="form-check-input"
                                type="radio"
                                :value="0"
                                v-model="formInput.waktu_meninggal"
                            />
                            <span class="form-check-label fw-semibold text-gray-500">
                                Sesudah 48 Jam
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Sebab Kematian </span>
                    </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.sebab_kematian"
                        cols="30"
                        rows="3"
                        placeholder="sebab kematian"
                    ></textarea>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { ref } from 'vue'

const pemeriksaanStore = usePasienPemeriksaanStore()

const formInput = ref(pemeriksaanStore.formInput.outcome)
</script>
