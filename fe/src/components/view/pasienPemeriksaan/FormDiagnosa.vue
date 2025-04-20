<template>
    <div class="row">
        <div class="col-12 col-xl-6 mb-4">
            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Jenis Sel </span>
                    </label>
                    <div class="d-flex align-items-center flex-wrap my-1">
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="1"
                            />
                            <span class="form-check-label fw-semibold"> Sel Kecil </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> Sel Besar </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="3"
                            />
                            <span class="form-check-label fw-semibold"> Adenokarsenoma </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="4"
                            />
                            <span class="form-check-label fw-semibold"> KSS </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10 mb-3">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="5"
                            />
                            <span class="form-check-label fw-semibold"> KPKBSK </span>
                        </label>
                    </div>
                    <form-error
                        :err="formInputValidated.diagnosa.jenis_sel"
                        name="diagnosa.jenis_sel"
                    />
                </div>
            </div>

            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> PS </span>
                    </label>
                    <div class="d-flex align-items-center flex-wrap my-1">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.ps"
                                :value="1"
                            />
                            <span class="form-check-label fw-semibold"> 1 </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.ps"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> 2 </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.ps"
                                :value="3"
                            />
                            <span class="form-check-label fw-semibold"> 3 </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.ps"
                                :value="4"
                            />
                            <span class="form-check-label fw-semibold"> 4 </span>
                        </label>
                    </div>
                    <form-error :err="formInputValidated.diagnosa.ps" name="diagnosa.ps" />
                </div>
            </div>

            <div class="border-dashed p-4 mb-4" style="position: relative">
                <h2 class="text-uppercase">Marker Molekular</h2>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark">
                            <span> EGFR </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input
                            class="form-control"
                            type="text"
                            autocomplete="off"
                            placeholder="EGFR"
                            v-model="formInput.mutasi"
                        />
                        <form-error
                            :err="formInputValidated.diagnosa.mutasi"
                            name="diagnosa.mutasi"
                        />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark">
                            <span> PD-L1 </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input
                            class="form-control"
                            type="text"
                            autocomplete="off"
                            placeholder="PD-L1"
                            v-model="formInput.pdl1"
                        />
                        <form-error :err="formInputValidated.diagnosa.pdl1" name="diagnosa.pdl1" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark mt-1">
                            <span> ALK </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div class="d-flex align-items-center my-1 mt-1">
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input
                                    multiple
                                    class="form-check-input h-20px w-20px"
                                    type="checkbox"
                                    v-model="formInput.alk"
                                    :value="1"
                                />
                                <span class="form-check-label fw-semibold"> Fusi(-) </span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input
                                    multiple
                                    class="form-check-input h-20px w-20px"
                                    type="checkbox"
                                    v-model="formInput.alk"
                                    :value="2"
                                />
                                <span class="form-check-label fw-semibold"> Fusi(+) </span>
                            </label>
                        </div>
                        <form-error :err="formInputValidated.diagnosa.alk" name="diagnosa.alk" />
                    </div>
                </div>
            </div>

            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Stage </span>
                    </label>
                    <div class="d-flex align-items-center my-1">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="1"
                            />
                            <span class="form-check-label fw-semibold"> IA </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> IIA </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="3"
                            />
                            <span class="form-check-label fw-semibold"> IIIA </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="4"
                            />
                            <span class="form-check-label fw-semibold"> IVA </span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center my-1 mt-4">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="5"
                            />
                            <span class="form-check-label fw-semibold"> IB </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="6"
                            />
                            <span class="form-check-label fw-semibold"> IIB </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="7"
                            />
                            <span class="form-check-label fw-semibold"> IIIB </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="8"
                            />
                            <span class="form-check-label fw-semibold"> IVB </span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center my-1 mt-4" style="margin-left: 147px">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="9"
                            />
                            <span class="form-check-label fw-semibold"> IIIC </span>
                        </label>
                    </div>
                    <form-error :err="formInputValidated.diagnosa.stage" name="diagnosa.stage" />
                </div>
            </div>

            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Paru </span>
                    </label>
                    <div class="d-flex align-items-center my-1">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.paru"
                                :value="1"
                            />
                            <span class="form-check-label fw-semibold"> Kiri </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.paru"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> Kanan </span>
                        </label>
                    </div>
                    <form-error :err="formInputValidated.diagnosa.paru" name="diagnosa.paru" />
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Komorbid </span>
                    </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.komorbid"
                        cols="30"
                        rows="6"
                        placeholder="komorbid"
                    ></textarea>
                    <form-error
                        :err="formInputValidated.diagnosa.komorbid"
                        name="diagnosa.komorbid"
                    />
                </div>
            </div>

            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span> Staging T </span>
                    </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.staging_t"
                        cols="30"
                        rows="4"
                        placeholder="staging t"
                    ></textarea>
                    <form-error
                        :err="formInputValidated.diagnosa.staging_t"
                        name="diagnosa.staging_t"
                    />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span> Staging N </span>
                    </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.staging_n"
                        cols="30"
                        rows="4"
                        placeholder="staging n"
                    ></textarea>
                    <form-error
                        :err="formInputValidated.diagnosa.staging_n"
                        name="diagnosa.staging_n"
                    />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span> Staging M </span>
                    </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.staging_m"
                        cols="30"
                        rows="4"
                        placeholder="staging m"
                    ></textarea>
                    <form-error
                        :err="formInputValidated.diagnosa.staging_m"
                        name="diagnosa.staging_m"
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

const formInput = ref(pemeriksaanStore.formUpdate.diagnosa)
const formInputValidated = ref(pemeriksaanStore.formUpdateValidated)
</script>
