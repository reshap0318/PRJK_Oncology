<template>
    <div class="border-dashed p-4 mb-4" style="position: relative">
        <h2 class="text-uppercase">Bronkoskopi</h2>
        <div class="row mt-3">
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span>Pita Suara</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="pita suara"
                        v-model="formInput.vocal_cords"
                    />
                    <form-error :err="v$.bronkoskopi.vocal_cords" name="bronkoskopi.vocal_cords" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span>Trakea</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="trakea"
                        v-model="formInput.trachea"
                    />
                    <form-error :err="v$.bronkoskopi.trachea" name="bronkoskopi.trachea" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span>Carina</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="carina"
                        v-model="formInput.carina"
                    />
                    <form-error :err="v$.bronkoskopi.carina" name="bronkoskopi.carina" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <h3 class="text-uppercase">Kanan</h3>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>BUKa</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="BUKa"
                        v-model="formInput.r_bu"
                    />
                    <form-error :err="v$.bronkoskopi.r_bu" name="bronkoskopi.r_bu" />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>Second Carina</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="second carina"
                        v-model="formInput.r_carina_second"
                    />
                    <form-error
                        :err="v$.bronkoskopi.r_carina_second"
                        name="bronkoskopi.r_carina_second"
                    />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>LAKa</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="LAKa"
                        v-model="formInput.r_la"
                    />
                    <form-error :err="v$.bronkoskopi.r_la" name="bronkoskopi.r_la" />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>TI</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="TI"
                        v-model="formInput.r_ti"
                    />
                    <form-error :err="v$.bronkoskopi.r_ti" name="bronkoskopi.r_ti" />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>LM</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="LM"
                        v-model="formInput.r_lm"
                    />
                    <form-error :err="v$.bronkoskopi.r_lm" name="bronkoskopi.r_lm" />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>LBKa</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="LBKa"
                        v-model="formInput.r_lb"
                    />
                    <form-error :err="v$.bronkoskopi.r_lb" name="bronkoskopi.r_lb" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <h3 class="text-uppercase">Kiri</h3>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>BUKa</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="BUKa"
                        v-model="formInput.l_bu"
                    />
                    <form-error :err="v$.bronkoskopi.l_bu" name="bronkoskopi.l_bu" />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>Second Carina</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="second carina"
                        v-model="formInput.l_carina_second"
                    />
                    <form-error
                        :err="v$.bronkoskopi.l_carina_second"
                        name="bronkoskopi.l_carina_second"
                    />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>LAKa (Upper Division)</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="LAKa"
                        v-model="formInput.l_la"
                    />
                    <form-error :err="v$.bronkoskopi.l_la" name="bronkoskopi.l_la" />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>Lower Division</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="lower division"
                        v-model="formInput.l_ld"
                    />
                    <form-error :err="v$.bronkoskopi.l_ld" name="bronkoskopi.l_ld" />
                </div>
                <div class="fv-row mb-4">
                    <label class="form-label fs-6 text-dark">
                        <span>LBKi</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="LBKi"
                        v-model="formInput.l_lb"
                    />
                    <form-error :err="v$.bronkoskopi.l_lb" name="bronkoskopi.l_lb" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span>Kesan</span>
                    </label>
                    <textarea
                        class="form-control"
                        placeholder="kesan"
                        v-model="formInput.description"
                        cols="30"
                        rows="2"
                    ></textarea>
                    <form-error :err="v$.bronkoskopi.description" name="bronkoskopi.description" />
                </div>
            </div>
            <div class="col-12 col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span>Staging</span>
                    </label>
                    <textarea
                        class="form-control"
                        placeholder="staging"
                        v-model="formInput.staging"
                        cols="30"
                        rows="2"
                    ></textarea>
                    <form-error :err="v$.bronkoskopi.staging" name="bronkoskopi.staging" />
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

const formInput = ref(pemeriksaanStore.formUpdate.bronkoskopi)
const v$ = ref(pemeriksaanStore.formUpdateValidated)
</script>
