<template>
    <div class="border-dashed p-4 mb-4" style="position: relative">
        <h2 class="text-uppercase">Outcome Pasien</h2>
        <div class="row">
            <div class="col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Tanggal Progress </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.progress" />
                    <form-error
                        :err="formInputValidated.outcome.progress"
                        name="outcome.progress"
                    />
                </div>
            </div>
            <div class="col-sm-6 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Tanggal Kematian </span>
                    </label>
                    <input type="date" class="form-control" v-model="formInput.dead" />
                    <form-error :err="formInputValidated.outcome.dead" name="outcome.dead" />
                </div>
            </div>
            <div class="col-sm-12 mb-4">
                <div class="fv-row">
                    <label class="form-label fs-6 text-dark">
                        <span> Sebab Kematian </span>
                    </label>
                    <textarea
                        class="form-control"
                        v-model="formInput.description"
                        cols="30"
                        rows="3"
                        placeholder="sebab kematian"
                    ></textarea>
                    <form-error
                        :err="formInputValidated.outcome.description"
                        name="outcome.description"
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

const formInput = ref(pemeriksaanStore.formUpdate.outcome)
const formInputValidated = ref(pemeriksaanStore.formUpdateValidated)
</script>
