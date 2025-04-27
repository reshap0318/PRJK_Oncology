<template>
    <div class="row">
        <div class="col-12 col-sm-6 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class="required"> Tanggal </span>
                </label>
                <input type="date" class="form-control" v-model="formInput.date" />
                <form-error :err="v$.laboratory.date" name="date" />
            </div>
        </div>
        <div class="col-12 col-sm-6 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> Hasil Laboratorium </span>
                </label>
                <InputFile v-model="formInput.result" :accept="['.pdf', '.jpg', '.jpeg', '.png']" />
                <a
                    v-if="formInput.result_url"
                    class="text-info"
                    target="_blank"
                    :href="formInput.result_url"
                    v-html="formInput.result_url"
                ></a>
                <form-error :err="v$.laboratory.result" name="result" />
            </div>
        </div>
        <div class="col-12 mb-4 mt-2">
            <div class="border-dashed" style="position: relative">
                <div class="row px-4">
                    <h4 class="text-uppercase" style="margin-top: -10px">Darah Rutin</h4>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> Hb </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.hb"
                            />
                            <form-error :err="v$.laboratory.hb" name="hb" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> Ht </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.ht"
                            />
                            <form-error :err="v$.laboratory.ht" name="ht" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> Leukosit </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.leukosit"
                            />
                            <form-error :err="v$.laboratory.leukosit" name="leukosit" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> Tr </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.tr"
                            />
                            <form-error :err="v$.laboratory.tr" name="tr" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> DC </span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    v-model="formInput.dc"
                    placeholder="0/0/0/0/0/0"
                />
                <form-error :err="v$.laboratory.dc" name="dc" />
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark"> Fungsi Hati </label>
                <textarea
                    v-model="formInput.liver_function"
                    cols="30"
                    rows="3"
                    class="form-control"
                    placeholder="fungsi hati"
                ></textarea>
                <form-error :err="v$.laboratory.liver_function" name="liver_function" />
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark"> Procalsitonin </label>
                <textarea
                    v-model="formInput.procalsitonin"
                    cols="30"
                    rows="3"
                    class="form-control"
                    placeholder="procalsitonin"
                ></textarea>
                <form-error :err="v$.laboratory.procalsitonin" name="procalsitonin" />
            </div>
        </div>
        <div class="col-12 mb-4 mt-2">
            <div class="border-dashed" style="position: relative">
                <div class="row px-4">
                    <h4 class="text-uppercase" style="margin-top: -10px">FUNGSI GINJAL</h4>
                    <div class="col-12 col-sm-4 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> Ur </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.ginjal_ur"
                            />
                            <form-error :err="v$.laboratory.ginjal_ur" name="ginjal_ur" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> Cr </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.ginjal_cr"
                            />
                            <form-error :err="v$.laboratory.ginjal_cr" name="ginjal_cr" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> CCT Urine </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.ginjal_cct"
                            />
                            <form-error :err="v$.laboratory.ginjal_cct" name="ginjal_cct" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4 mt-2">
            <div class="border-dashed" style="position: relative">
                <div class="row px-4">
                    <h4 class="text-uppercase" style="margin-top: -10px">Elektrolit (Na/K/CL)</h4>
                    <div class="col-12 col-sm-4 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> Na </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0"
                                v-model="formInput.elektrolit_na"
                            />
                            <form-error :err="v$.laboratory.elektrolit_na" name="elektrolit_na" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> K </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0"
                                v-model="formInput.elektrolit_k"
                            />
                            <form-error :err="v$.laboratory.elektrolit_k" name="elektrolit_k" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> CL </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0"
                                v-model="formInput.elektrolit_cl"
                            />
                            <form-error :err="v$.laboratory.elektrolit_cl" name="elektrolit_cl" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4 mt-2">
            <div class="border-dashed" style="position: relative">
                <div class="row px-4">
                    <h4 class="text-uppercase" style="margin-top: -10px">AGD</h4>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> pH </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.agd_ph"
                            />
                            <form-error :err="v$.laboratory.agd_ph" name="agd_ph" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> HCO3 </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.agd_hco3"
                            />
                            <form-error :err="v$.laboratory.agd_hco3" name="agd_hco3" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> PCO2 </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.agd_pco2"
                            />
                            <form-error :err="v$.laboratory.agd_pco2" name="agd_pco2" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> BE </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.agd_be"
                            />
                            <form-error :err="v$.laboratory.agd_be" name="agd_be" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> PO2 </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.agd_po2"
                            />
                            <form-error :err="v$.laboratory.agd_po2" name="agd_po2" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span class=""> S02 </span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                min="0"
                                placeholder="0,0"
                                v-model="formInput.agd_so2"
                            />
                            <form-error :err="v$.laboratory.agd_so2" name="agd_so2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark">
                    <span class=""> GDS </span>
                </label>
                <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    v-model="formInput.gds"
                    placeholder="0.0"
                    min="0"
                />
                <form-error :err="v$.laboratory.gds" name="gds" />
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="fv-row">
                <label class="form-label fs-6 text-dark"> Keterangan </label>
                <textarea
                    v-model="formInput.description"
                    cols="30"
                    rows="3"
                    class="form-control"
                    placeholder="keterangan"
                ></textarea>
                <form-error :err="v$.laboratory.description" name="description" />
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import FormError from '@/components/utils/error/FormError.vue'
import InputFile from '@/components/utils/form/InputFile.vue'

import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { ref } from 'vue'

const pemeriksaanStore = usePasienPemeriksaanStore()

const formInput = ref(pemeriksaanStore.formUpdate.laboratory)
const v$ = ref(pemeriksaanStore.formUpdateValidated)
</script>
