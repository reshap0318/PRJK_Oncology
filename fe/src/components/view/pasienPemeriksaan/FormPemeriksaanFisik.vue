<template>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="border-dashed p-4" style="position: relative">
                <h2 class="text-uppercase">Tanda Vital</h2>
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Kesadaran </span>
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="kesadaran"
                                v-model="formInput.awareness"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.awareness"
                                name="pemeriksaan_fisik.awareness"
                            />
                        </div>
                    </div>
                    <div class="col-sm-8 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Keadaan Umum </span>
                            </label>
                            <div class="d-flex align-items-center my-3">
                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer me-8"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        :value="1"
                                        v-model="formInput.condition"
                                    />
                                    <span class="form-check-label fw-semibold text-gray-500">
                                        Baik
                                    </span>
                                </label>

                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer me-8"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        :value="2"
                                        v-model="formInput.condition"
                                    />
                                    <span class="form-check-label fw-semibold text-gray-500">
                                        Sedang
                                    </span>
                                </label>

                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer me-8"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        :value="3"
                                        v-model="formInput.condition"
                                    />
                                    <span class="form-check-label fw-semibold text-gray-500">
                                        Buruk
                                    </span>
                                </label>

                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        :value="4"
                                        v-model="formInput.condition"
                                    />
                                    <span class="form-check-label fw-semibold text-gray-500">
                                        Sangat Buruk
                                    </span>
                                </label>
                            </div>
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.condition"
                                name="pemeriksaan_fisik.condition"
                            />
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> TD </span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    v-model="formInput.td"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> mmHg </span>
                                </div>
                            </div>
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.td"
                                name="pemeriksaan_fisik.td"
                            />
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> RR </span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    v-model="formInput.rr"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> kali/menit </span>
                                </div>
                            </div>
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.rr"
                                name="pemeriksaan_fisik.rr"
                            />
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> SpO2 </span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    v-model="formInput.sp_o2"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> % room air </span>
                                </div>
                            </div>
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.sp_o2"
                                name="pemeriksaan_fisik.sp_o2"
                            />
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Nadi </span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    v-model="formInput.nadi"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> kali/menit </span>
                                </div>
                            </div>
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.nadi"
                                name="pemeriksaan_fisik.nadi"
                            />
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Suhu </span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    v-model="formInput.suhu"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> C </span>
                                </div>
                            </div>
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.suhu"
                                name="pemeriksaan_fisik.suhu"
                            />
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> VAS </span>
                            </label>
                            <input
                                type="number"
                                class="form-control"
                                min="0"
                                v-model="formInput.vas"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.vas"
                                name="pemeriksaan_fisik.vas"
                            />
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Keterangan </span>
                            </label>
                            <textarea
                                class="form-control"
                                v-model="formInput.description"
                                cols="30"
                                rows="3"
                                placeholder="keterangan lainnya"
                            ></textarea>
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.description"
                                name="pemeriksaan_fisik.description"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="border-dashed p-4" style="position: relative">
                <h2 class="text-uppercase">KGB</h2>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="1"
                            v-model="formInput.kgb_option"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="0"
                            v-model="formInput.kgb_option"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <textarea
                    v-if="formInput.kgb_option == 1"
                    class="form-control"
                    v-model="formInput.kgb"
                    cols="30"
                    rows="3"
                    placeholder="lokasi kgb"
                ></textarea>
                <form-error
                    :err="formInputValidated.pemeriksaan_fisik.kgb"
                    name="pemeriksaan_fisik.kgb"
                />
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="border-dashed p-4" style="position: relative">
                <h2 class="text-uppercase">Paru</h2>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Inspeksi </span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                v-model="formInput.inspeksi_statis"
                                placeholder="statis"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.inspeksi_statis"
                                name="pemeriksaan_fisik.inspeksi_statis"
                            />
                            <input
                                type="text"
                                class="form-control mt-4"
                                autocomplete="off"
                                v-model="formInput.inspeksi_dinamis"
                                placeholder="dinamis"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.inspeksi_dinamis"
                                name="pemeriksaan_fisik.inspeksi_dinamis"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Palpasi </span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                v-model="formInput.palpasi"
                                placeholder="palpasi"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.palpasi"
                                name="pemeriksaan_fisik.palpasi"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Perkusi </span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                v-model="formInput.perkusi"
                                placeholder="perkusi"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.perkusi"
                                name="pemeriksaan_fisik.perkusi"
                            />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Auskultasi </span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                v-model="formInput.auskultasi"
                                placeholder="auskultasi"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.auskultasi"
                                name="pemeriksaan_fisik.auskultasi"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Abdomen </span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                v-model="formInput.abdomen"
                                placeholder="abdomen"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.abdomen"
                                name="pemeriksaan_fisik.abdomen"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Ekstemitas </span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                v-model="formInput.ekstemitas"
                                placeholder="ekstemitas"
                            />
                            <form-error
                                :err="formInputValidated.pemeriksaan_fisik.ekstemitas"
                                name="pemeriksaan_fisik.ekstemitas"
                            />
                        </div>
                    </div>
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

const formInput = ref(pemeriksaanStore.formUpdate.pemeriksaan_fisik)
const formInputValidated = ref(pemeriksaanStore.formUpdateValidated)
</script>
