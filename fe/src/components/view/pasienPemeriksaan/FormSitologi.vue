<template>
    <h2 class="text-uppercase pb-2">PA</h2>
    <div class="row">
        <div class="col-12 mb-4 mt-3" v-for="(item, i) in formInput" :key="i">
            <div class="border-dashed" style="position: relative">
                <div class="row px-4">
                    <h4 class="text-uppercase" style="margin-top: -10px">{{ item.label }}</h4>
                    <div class="col-12 col-sm-6">
                        <div class="fv-row mb-4">
                            <label class="form-label fs-6 text-dark"> Tanggal </label>
                            <input type="date" class="form-control" v-model="item.date" />
                        </div>
                        <div class="fv-row mb-4">
                            <label class="form-label fs-6 text-dark"> Keterangan </label>
                            <textarea
                                class="form-control"
                                cols="30"
                                rows="3"
                                placeholder="keterangan"
                                v-model="item.description"
                            ></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="fv-row mb-4">
                            <div class="d-flex align-items-center mb-7" style="margin-top: 37px">
                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        value="1"
                                        v-model="item.type"
                                    />
                                    <span class="form-check-label fw-semibold text-gray-500">
                                        Sel Ganas (+)
                                    </span>
                                </label>
                                <label
                                    class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                >
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        value="0"
                                        v-model="item.type"
                                    />
                                    <span class="form-check-label fw-semibold text-gray-500">
                                        Tidak Ditemukan Sel Ganas
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="fv-row mb-4" v-if="item.type == 1">
                            <select class="form-control" v-model="item.type_detail">
                                <option :value="null">Jenis Sel</option>
                                <option
                                    v-for="d in selectStore.sitologis"
                                    :key="d.value"
                                    :value="d.value"
                                >
                                    {{ d.label }}
                                </option>
                            </select>
                            <form-each-error
                                :err="formInputValidated.sitologis"
                                :idx="i"
                                code="type_detail"
                                name="sitologis"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import FormEachError from '@/components/utils/error/FormEachError.vue'
import { usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { useSelectStore } from '@/stores/global/select'
import { onMounted, ref } from 'vue'

const pemeriksaanStore = usePasienPemeriksaanStore()
const selectStore = useSelectStore()

const formInput = ref(pemeriksaanStore.formUpdate.sitologis)
const formInputValidated = ref(pemeriksaanStore.formUpdateValidated)

onMounted(() => {
    selectStore.getSitologiCategorys()
})
</script>
