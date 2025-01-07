<template>
    <BaseModal modalId="pemeriksaan" ref="modal" width="modal-fullscreen">
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body py-4">
                        <div
                            class="row my-3 rounded"
                            v-for="d in menus"
                            :class="formActive == d.code ? 'bg-info' : 'bg-gray-200'"
                            :key="d.code"
                            @click="formActive = d.code"
                        >
                            <div
                                class="col-12 p-5 d-flex flex-row align-items-center cursor-pointer"
                            >
                                <div class="me-4">
                                    <i
                                        class="fa fa-check-circle fs-2"
                                        :class="formActive == d.code ? 'text-white' : ''"
                                    ></i>
                                </div>
                                <span
                                    class="fw-bolder fs-4 text-uppercase pb-1"
                                    :class="formActive == d.code ? 'text-white' : 'text-gray-800'"
                                    v-html="d.label"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <template v-if="formActive == 'ONC001'">
                            <div class="d-flex justify-content-between mb-2 align-items-center">
                                <div class="d-flex">
                                    <KTIcon icon-name="pencil" icon-class="fs-2" />
                                    <h2 class="ms-3 mb-0 text-uppercase">Keluhan</h2>
                                </div>
                                <button
                                    class="btn btn-info btn-sm"
                                    type="button"
                                    @click="tambahKeluhan"
                                >
                                    Tambah
                                </button>
                            </div>
                            <div
                                class="border-dashed mt-4"
                                style="position: relative"
                                v-for="(d, i) in formInput.keluhans"
                                :key="i"
                            >
                                <button
                                    class="btn btn-icon btn-sm"
                                    style="position: absolute; right: -17px; top: -17px"
                                    @click="hapusKeluhan(i)"
                                    v-if="i != 0"
                                >
                                    <KTIcon
                                        icon-name="trash-square"
                                        icon-class="text-danger"
                                        style="font-size: 2.3rem"
                                    />
                                </button>
                                <div class="row px-3 py-5">
                                    <div class="col-9">
                                        <div class="fv-row">
                                            <label class="form-label fs-6 text-dark">
                                                <span class="required">Keluhan</span>
                                            </label>
                                            <input
                                                tabindex="1"
                                                class="form-control"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="keluhan"
                                                v-model="d.description"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="fv-row">
                                            <label class="form-label fs-6 text-dark">
                                                <span class="required">Lama Keluhan</span>
                                            </label>
                                            <div class="input-group mb-3">
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    min="0"
                                                    v-model="d.long"
                                                />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"> Bulan </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-dashed mt-4" style="position: relative">
                                <!-- <h2
                                    class="text-uppercase"
                                    style="position: absolute; top: -12px; left: 10px"
                                >
                                    Gejala
                                </h2> -->
                                <div class="pt-4"></div>
                                <div class="row px-3" v-for="(d, i) in formInput.gejalas" :key="i">
                                    <div class="col-12 mb-3">
                                        <div class="fv-row">
                                            <label class="form-label fs-6 text-dark">
                                                <span class="required">Gejala</span>
                                            </label>
                                            <input
                                                tabindex="1"
                                                class="form-control"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="gejala"
                                                v-model="d.description"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <div class="fv-row">
                                            <label class="form-label fs-6 text-dark">
                                                <span class="required">Lama Keluhan</span>
                                            </label>
                                            <div class="input-group mb-3">
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    min="0"
                                                    v-model="d.long"
                                                />
                                                <div class="input-group-append">
                                                    <span class="input-group-text"> Bulan </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button
                                            class="btn btn-info mt-8"
                                            v-if="i == formInput.gejalas.length - 1"
                                            @click="tambahGejala"
                                        >
                                            Tambah
                                        </button>
                                        <button
                                            v-else
                                            class="btn btn-danger mt-8"
                                            @click="hapusGejala(i)"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else-if="formActive == 'ONC002'">B</template>
                        <template v-else-if="formActive == 'ONC003'">C</template>
                        <template v-else-if="formActive == 'ONC004'">D</template>
                        <template v-else-if="formActive == 'ONC005'">E</template>
                        <template v-else-if="formActive == 'ONC006'">F</template>
                    </div>
                </div>
            </div>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import { ref } from 'vue'

const modal = ref()
const formActive = ref('ONC001')
const menus = ref([
    {
        code: 'ONC001',
        label: 'Anemnesis'
    },
    {
        code: 'ONC002',
        label: 'Pemeriksaan Fisik'
    },
    {
        code: 'ONC003',
        label: 'Penunjang'
    },
    {
        code: 'ONC004',
        label: 'Diagnosa'
    },
    {
        code: 'ONC005',
        label: 'Tatalaksana'
    },
    {
        code: 'ONC006',
        label: 'Outcome'
    }
])

const formInput = ref({
    keluhans: [
        {
            description: null,
            long: 0
        }
    ],
    gejalas: [
        {
            description: null,
            long: 0
        }
    ]
})

function tambahKeluhan() {
    formInput.value.keluhans.push({
        description: null,
        long: 0
    })
}

function hapusKeluhan(idx: number) {
    formInput.value.keluhans.splice(idx, 1)
}

function tambahGejala() {
    formInput.value.gejalas.push({
        description: null,
        long: 0
    })
}

function hapusGejala(idx: number) {
    formInput.value.gejalas.splice(idx, 1)
}

function show() {
    formActive.value = 'ONC001'
    modal.value.show()
}

defineExpose({
    show
})
</script>

<style>
#modal_pemeriksaan .modal-body {
    --bs-bg-rgb-color: var(--bs-gray-400-rgb);
    background-color: #ebedee;
}
</style>
