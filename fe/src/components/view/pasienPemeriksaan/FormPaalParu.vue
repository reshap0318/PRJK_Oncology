<template>
    <div class="border-dashed p-4 mb-4" style="position: relative">
        <h2 class="text-uppercase">Paal Paru</h2>
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> KVP </span>
                    </label>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="formInput.kvp_ml"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> ml </span>
                                </div>
                            </div>
                            <form-error :err="v$.paal_paru.kvp_ml" name="paal_paru.kvp_ml" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="formInput.kvp_percent"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> % </span>
                                </div>
                            </div>
                            <form-error
                                :err="v$.paal_paru.kvp_percent"
                                name="paal_paru.kvp_percent"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> VEP1 </span>
                    </label>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="formInput.vep_ml"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> ml </span>
                                </div>
                            </div>
                            <form-error :err="v$.paal_paru.vep_ml" name="paal_paru.vep_ml" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="formInput.vep_percent"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> % </span>
                                </div>
                            </div>
                            <form-error
                                :err="v$.paal_paru.vep_percent"
                                name="paal_paru.vep_percent"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span>VEP1/KVP</span>
                    </label>
                    <div class="input-group">
                        <input
                            type="number"
                            class="form-control"
                            min="0"
                            placeholder="0"
                            v-model="formInput.vep_kvp"
                        />
                        <div class="input-group-append">
                            <span class="input-group-text"> % </span>
                        </div>
                    </div>
                    <form-error :err="v$.paal_paru.vep_kvp" name="paal_paru.vep_kvp" />
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark"> Resume </label>
                    <textarea
                        v-model="formInput.description"
                        cols="30"
                        rows="3"
                        class="form-control"
                        placeholder="resume"
                    ></textarea>
                    <form-error :err="v$.paal_paru.description" name="paal_paru.description" />
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

const formInput = ref(pemeriksaanStore.formUpdate.paal_paru)
const v$ = ref(pemeriksaanStore.formUpdateValidated)
</script>
