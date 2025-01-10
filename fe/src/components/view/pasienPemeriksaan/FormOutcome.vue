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
                    <form-error
                        :err="formInputValidated.outcome.keadaan_pulang"
                        name="outcome.keadaan_pulang"
                    />
                </div>
            </div>
            <div class="col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Cara Pulang </span>
                    </label>
                    <select v-model="formInput.cara_pulang" class="form-control">
                        <option :value="null">Cara Pulang</option>
                        <option value="1">Atas Persetujuan</option>
                        <option value="2">Pulang Paksa</option>
                        <option value="3">Pindah RS Lain</option>
                        <option value="4">Lari</option>
                        <option value="5">Meninggal Dunia</option>
                    </select>
                    <form-error
                        :err="formInputValidated.outcome.cara_pulang"
                        name="outcome.cara_pulang"
                    />
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Lama Dirawat </span>
                    </label>
                    <div class="input-group">
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
                    <form-error
                        :err="formInputValidated.outcome.lama_dirawat"
                        name="outcome.lama_dirawat"
                    />
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required">Tanggal Meninggal </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.tanggal_meninggal" />
                    <form-error
                        :err="formInputValidated.outcome.tanggal_meninggal"
                        name="outcome.tanggal_meninggal"
                    />
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
                    <form-error
                        :err="formInputValidated.outcome.waktu_meninggal"
                        name="outcome.waktu_meninggal"
                    />
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
                    <form-error
                        :err="formInputValidated.outcome.sebab_kematian"
                        name="outcome.sebab_kematian"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import FormError from '@/components/utils/error/FormError.vue'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { ref } from 'vue'

const pemeriksaanStore = usePasienPemeriksaanStore()

const formInput = ref(pemeriksaanStore.formInput.outcome)
const formInputValidated = ref(pemeriksaanStore.formInputValidated)
</script>
