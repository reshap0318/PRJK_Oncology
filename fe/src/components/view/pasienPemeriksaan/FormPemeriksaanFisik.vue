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
                                v-model="formInput.kesadaran"
                            />
                        </div>
                    </div>
                    <div class="col-sm-8 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Keadaan Umum </span>
                            </label>
                            <div class="d-flex align-items-center mt-3">
                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer me-8"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        :value="1"
                                        v-model="formInput.keadaan_umum"
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
                                        v-model="formInput.keadaan_umum"
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
                                        v-model="formInput.keadaan_umum"
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
                                        v-model="formInput.keadaan_umum"
                                    />
                                    <span class="form-check-label fw-semibold text-gray-500">
                                        Sangat Buruk
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> TD </span>
                            </label>
                            <div class="input-group mb-3">
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
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> RR </span>
                            </label>
                            <div class="input-group mb-3">
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
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> SpO2 </span>
                            </label>
                            <div class="input-group mb-3">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    v-model="formInput.spo2"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> % room air </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Nadi </span>
                            </label>
                            <div class="input-group mb-3">
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
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class="required"> Suhu </span>
                            </label>
                            <div class="input-group mb-3">
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
                        <input class="form-check-input" type="radio" :value="1" v-model="kgb" />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input class="form-check-input" type="radio" :value="0" v-model="kgb" />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <textarea
                    v-if="kgb == 1"
                    class="form-control"
                    v-model="formInput.kgb"
                    cols="30"
                    rows="3"
                    placeholder="lokasi kgb"
                ></textarea>
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
                                class="form-control mb-4"
                                autocomplete="off"
                                v-model="formInput.inspeksi_statis"
                                placeholder="statis"
                            />
                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                v-model="formInput.inspeksi_dinamis"
                                placeholder="dinamis"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Palpasi </span>
                            </label>
                            <input
                                type="text"
                                class="form-control mb-4"
                                autocomplete="off"
                                v-model="formInput.palpasi"
                                placeholder="palpasi"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Perkusi </span>
                            </label>
                            <input
                                type="text"
                                class="form-control mb-4"
                                autocomplete="off"
                                v-model="formInput.perkusi"
                                placeholder="perkusi"
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
                                class="form-control mb-4"
                                autocomplete="off"
                                v-model="formInput.auskultasi"
                                placeholder="auskultasi"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Abdomen </span>
                            </label>
                            <input
                                type="text"
                                class="form-control mb-4"
                                autocomplete="off"
                                v-model="formInput.abdomen"
                                placeholder="abdomen"
                            />
                        </div>
                        <div class="border-dashed py-4 px-6 mb-4" style="position: relative">
                            <label class="form-label text-dark">
                                <span class="required"> Ekstemitas </span>
                            </label>
                            <input
                                type="text"
                                class="form-control mb-4"
                                autocomplete="off"
                                v-model="formInput.ekstemitas"
                                placeholder="ekstemitas"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { ref } from 'vue'

const pemeriksaanStore = usePasienPemeriksaanStore()
const kgb = ref(0)

const formInput = ref(pemeriksaanStore.formInput.pemeriksaan_fisik)
</script>
