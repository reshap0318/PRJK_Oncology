<template>
    <div class="row">
        <div class="col-12 col-sm-6 mb-4">
            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Jenis Sel </span>
                    </label>
                    <div class="d-flex align-items-center my-1">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="1"
                            />
                            <span class="form-check-label fw-semibold"> Sel Kecil </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> Sel Besar </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="3"
                            />
                            <span class="form-check-label fw-semibold"> Adenokarsenoma </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.jenis_sel"
                                :value="4"
                            />
                            <span class="form-check-label fw-semibold"> KSS </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Stage </span>
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
                            <span class="form-check-label fw-semibold"> 1A </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> 2A </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="3"
                            />
                            <span class="form-check-label fw-semibold"> 3A </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="4"
                            />
                            <span class="form-check-label fw-semibold"> 4A </span>
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
                            <span class="form-check-label fw-semibold"> 1B </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="6"
                            />
                            <span class="form-check-label fw-semibold"> 2B </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="7"
                            />
                            <span class="form-check-label fw-semibold"> 3B </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="8"
                            />
                            <span class="form-check-label fw-semibold"> 4B </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-dashed p-4 mb-4" style="position: relative">
                <h2 class="text-uppercase">Marker Molekular</h2>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark">
                            <span class="required"> EGFR </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input
                            class="form-control"
                            type="text"
                            autocomplete="off"
                            placeholder="egfr"
                            v-model="formInput.egfr"
                        />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark">
                            <span class="required"> Mutasi </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input
                            class="form-control"
                            type="text"
                            autocomplete="off"
                            placeholder="mutasi"
                            v-model="formInput.mutasi"
                        />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark">
                            <span class="required"> WhildType </span>
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stage"
                                :value="5"
                            />
                            <span class="form-check-label fw-semibold"> 1B </span>
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark">
                            <span class="required"> PD-L1 </span>
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
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 align-self-center">
                        <label class="form-label fs-6 text-dark mt-1">
                            <span class="required"> ALK </span>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Paru </span>
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
                </div>
            </div>
            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Stagging </span>
                    </label>
                    <div class="d-flex align-items-center my-1">
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stagging"
                                :value="1"
                            />
                            <span class="form-check-label fw-semibold"> T </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stagging"
                                :value="2"
                            />
                            <span class="form-check-label fw-semibold"> N </span>
                        </label>
                        <label class="form-check form-check-custom form-check-solid me-10">
                            <input
                                multiple
                                class="form-check-input h-20px w-20px"
                                type="checkbox"
                                v-model="formInput.stagging"
                                :value="3"
                            />
                            <span class="form-check-label fw-semibold"> M </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> PS </span>
                    </label>
                    <div class="d-flex align-items-center my-1">
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
                    </div>
                </div>
            </div>
            <div class="border-dashed p-4 mb-4" style="position: relative">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span class="required"> Komorbid </span>
                    </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.komorbid"
                        cols="30"
                        rows="7"
                        placeholder="komorbid"
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

const formInput = ref(pemeriksaanStore.formInput.diagnosa)
</script>
