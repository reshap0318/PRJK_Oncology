<template>
    <BaseModal modalId="pemeriksaan" ref="modal" width="modal-fullscreen">
        <template #title>
            <button class="btn btn-success btn-sm">Simpan</button>
        </template>
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
                <pre>{{ formInput }}</pre>
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <template v-if="formActive == 'ONC001'">
                            <div class="row">
                                <div class="col-12">
                                    <div class="border-dashed mt-4" style="position: relative">
                                        <div class="pt-4"></div>
                                        <div
                                            class="row px-3"
                                            v-for="(d, i) in formInput.keluhans"
                                            :key="i"
                                        >
                                            <div class="col-12 mb-3">
                                                <div class="fv-row">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Keluhan</span>
                                                    </label>
                                                    <input
                                                        class="form-control"
                                                        type="text"
                                                        autocomplete="off"
                                                        placeholder="keluhan"
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
                                                            <span class="input-group-text">
                                                                Bulan
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button
                                                    class="btn btn-info mt-8"
                                                    v-if="i == formInput.keluhans.length - 1"
                                                    @click="tambahKeluhan"
                                                >
                                                    Tambah
                                                </button>
                                                <button
                                                    v-else
                                                    class="btn btn-danger mt-8"
                                                    @click="hapusKeluhan(i)"
                                                >
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border-dashed mt-4" style="position: relative">
                                        <div class="pt-4"></div>
                                        <div
                                            class="row px-3"
                                            v-for="(d, i) in formInput.gejalas"
                                            :key="i"
                                        >
                                            <div class="col-12 mb-3">
                                                <div class="fv-row">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Gejala</span>
                                                    </label>
                                                    <input
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
                                                            <span class="input-group-text">
                                                                Bulan
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button
                                                    class="btn btn-info mt-8"
                                                    v-if="i == formInput.gejalas.length - 1"
                                                    @click="tambahGejala()"
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
                                </div>
                                <div class="col-12">
                                    <div class="border-dashed mt-4" style="position: relative">
                                        <div class="pt-4">
                                            <div
                                                class="row px-3"
                                                v-for="(d, i) in formInput.penyakits"
                                                :key="i"
                                            >
                                                <div class="col-12 col-sm-11 mb-3">
                                                    <div class="fv-row">
                                                        <label class="form-label fs-6 text-dark">
                                                            <span class="required">Penyakit</span>
                                                        </label>
                                                        <input
                                                            class="form-control"
                                                            type="text"
                                                            autocomplete="off"
                                                            placeholder="penyakit"
                                                            v-model="d.description"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-1 mb-3">
                                                    <button
                                                        class="btn btn-info mt-8"
                                                        style="margin-left: -3px"
                                                        v-if="i == formInput.penyakits.length - 1"
                                                        @click="tambahPenyakit()"
                                                    >
                                                        Tambah
                                                    </button>
                                                    <button
                                                        v-else
                                                        class="btn btn-danger mt-8"
                                                        @click="hapusPenyakit(i)"
                                                    >
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required">Riwayat Merokok</span>
                                        </label>
                                        <div class="d-flex align-items-center">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="1"
                                                    v-model="formInput.kategori_perokok.riwayat"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Perokok
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="2"
                                                    v-model="formInput.kategori_perokok.riwayat"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Bekas Perokok
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="3"
                                                    v-model="formInput.kategori_perokok.riwayat"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Bukan Perokok
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="row mt-5"
                                            v-if="
                                                [1, 2].includes(formInput.kategori_perokok.riwayat)
                                            "
                                        >
                                            <div
                                                class="col-sm-3 mb-3"
                                                v-if="formInput.kategori_perokok.riwayat == 1"
                                            >
                                                <div class="fv-row">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Jumlah</span>
                                                    </label>
                                                    <input
                                                        class="form-control"
                                                        type="number"
                                                        min="0"
                                                        autocomplete="off"
                                                        placeholder="batang / tahun"
                                                        v-model="formInput.kategori_perokok.jumlah"
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-sm-3 mb-3">
                                                <div class="fv-row">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Lama Merokok</span>
                                                    </label>
                                                    <input
                                                        class="form-control"
                                                        type="number"
                                                        min="0"
                                                        autocomplete="off"
                                                        placeholder="tahun"
                                                        v-model="formInput.kategori_perokok.lama"
                                                    />
                                                </div>
                                            </div>

                                            <div
                                                class="col-sm-6 mb-3"
                                                v-if="formInput.kategori_perokok.riwayat == 1"
                                            >
                                                <div class="d-flex align-items-center mt-12">
                                                    <label
                                                        class="form-label fs-6 text-dar ms-12 me-7 mb-0"
                                                    >
                                                        <span class="required">IB</span>
                                                    </label>

                                                    <label
                                                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                                    >
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            value="1"
                                                            v-model="formInput.kategori_perokok.ib"
                                                        />
                                                        <span
                                                            class="form-check-label fw-semibold text-gray-500"
                                                        >
                                                            R
                                                        </span>
                                                    </label>

                                                    <label
                                                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                                    >
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            value="2"
                                                            v-model="formInput.kategori_perokok.ib"
                                                        />
                                                        <span
                                                            class="form-check-label fw-semibold text-gray-500"
                                                        >
                                                            S
                                                        </span>
                                                    </label>

                                                    <label
                                                        class="form-check form-check-custom form-check-solid cursor-pointer"
                                                    >
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            value="3"
                                                            v-model="formInput.kategori_perokok.ib"
                                                        />
                                                        <span
                                                            class="form-check-label fw-semibold text-gray-500"
                                                        >
                                                            B
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div
                                                class="col-sm-3 mb-3"
                                                v-if="formInput.kategori_perokok.riwayat == 1"
                                            >
                                                <div class="fv-row">
                                                    <input
                                                        class="form-control"
                                                        type="number"
                                                        min="0"
                                                        autocomplete="off"
                                                        placeholder="tahun"
                                                        v-model="
                                                            formInput.kategori_perokok.kategori
                                                        "
                                                    />
                                                </div>
                                            </div>

                                            <div
                                                class="col-sm-9 mb-3"
                                                v-if="formInput.kategori_perokok.riwayat == 1"
                                            >
                                                <div class="d-flex align-items-center mt-3">
                                                    <label
                                                        class="form-label fs-6 text-dar me-7 mb-0"
                                                    >
                                                        <span class="required">Cara Menghisap</span>
                                                    </label>

                                                    <label
                                                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                                    >
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            value="1"
                                                            v-model="
                                                                formInput.kategori_perokok
                                                                    .cara_menghisap
                                                            "
                                                        />
                                                        <span
                                                            class="form-check-label fw-semibold text-gray-500"
                                                        >
                                                            Dalam
                                                        </span>
                                                    </label>

                                                    <label
                                                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                                    >
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            value="0"
                                                            v-model="
                                                                formInput.kategori_perokok
                                                                    .cara_menghisap
                                                            "
                                                        />
                                                        <span
                                                            class="form-check-label fw-semibold text-gray-500"
                                                        >
                                                            Tidak Dalam
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required">
                                                Paparan Asap Rokok Lingkungan
                                            </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="1"
                                                    v-model="formInput.paparan_asap_rokok"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="0"
                                                    v-model="formInput.paparan_asap_rokok"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required"> Pekerjaan Beresiko </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="1"
                                                    v-model="formInput.pekerjaan_beresiko.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="0"
                                                    v-model="formInput.pekerjaan_beresiko.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="fv-row mt-4"
                                            v-if="formInput.pekerjaan_beresiko.value == 1"
                                        >
                                            <input
                                                class="form-control"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="keterangan"
                                                v-model="formInput.pekerjaan_beresiko.description"
                                            />
                                        </div>
                                    </div>

                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required">
                                                Tempat Tinggal Disekitar Pabrik
                                            </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="1"
                                                    v-model="
                                                        formInput.tempat_tinggal_sekitar_pabrik
                                                            .value
                                                    "
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="0"
                                                    v-model="
                                                        formInput.tempat_tinggal_sekitar_pabrik
                                                            .value
                                                    "
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="fv-row mt-4"
                                            v-if="
                                                formInput.tempat_tinggal_sekitar_pabrik.value == 1
                                            "
                                        >
                                            <input
                                                class="form-control"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="keterangan"
                                                v-model="
                                                    formInput.tempat_tinggal_sekitar_pabrik
                                                        .description
                                                "
                                            />
                                        </div>
                                    </div>

                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark my-3">
                                            <span class="required">
                                                Riwayat Keganasan di Organ Lain
                                            </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="1"
                                                    v-model="
                                                        formInput.riwayat_keganasan_organ_lain.value
                                                    "
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="0"
                                                    v-model="
                                                        formInput.riwayat_keganasan_organ_lain.value
                                                    "
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="fv-row mt-4"
                                            v-if="formInput.riwayat_keganasan_organ_lain.value == 1"
                                        >
                                            <input
                                                class="form-control"
                                                type="text"
                                                autocomplete="off"
                                                placeholder="keterangan"
                                                v-model="
                                                    formInput.riwayat_keganasan_organ_lain
                                                        .description
                                                "
                                            />
                                        </div>
                                    </div>

                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required"> Paparan Radon </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="1"
                                                    v-model="formInput.paparan_radon.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="0"
                                                    v-model="formInput.paparan_radon.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>

                                        <div
                                            class="d-flex align-items-center mt-6 mb-3"
                                            v-if="formInput.paparan_radon.value == 1"
                                        >
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10"
                                            >
                                                <input
                                                    class="form-check-input h-20px w-20px"
                                                    type="checkbox"
                                                    v-model="
                                                        formInput.paparan_radon.description
                                                            .rumah_kayu
                                                    "
                                                    :value="1"
                                                />
                                                <span class="form-check-label fw-semibold">
                                                    Rumah Kayu
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10"
                                            >
                                                <input
                                                    class="form-check-input h-20px w-20px"
                                                    type="checkbox"
                                                    v-model="
                                                        formInput.paparan_radon.description
                                                            .lantai_retak
                                                    "
                                                    :value="1"
                                                />
                                                <span class="form-check-label fw-semibold">
                                                    Lantai Retak
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10"
                                            >
                                                <input
                                                    class="form-check-input h-20px w-20px"
                                                    type="checkbox"
                                                    v-model="
                                                        formInput.paparan_radon.description
                                                            .sumur_dalam_rumah
                                                    "
                                                    :value="1"
                                                />
                                                <span class="form-check-label fw-semibold">
                                                    Sumur Dalam Rumah
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required"> Biomess </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="1"
                                                    v-model="formInput.biomess.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="0"
                                                    v-model="formInput.biomess.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="d-flex align-items-center mt-6 mb-3"
                                            v-if="formInput.biomess.value == 1"
                                        >
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10"
                                            >
                                                <input
                                                    class="form-check-input h-20px w-20px"
                                                    type="checkbox"
                                                    v-model="
                                                        formInput.biomess.description.kayu_bakar
                                                    "
                                                    :value="1"
                                                />
                                                <span class="form-check-label fw-semibold">
                                                    Kayu Bakar
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10"
                                            >
                                                <input
                                                    class="form-check-input h-20px w-20px"
                                                    type="checkbox"
                                                    v-model="
                                                        formInput.biomess.description.minyak_tanah
                                                    "
                                                    :value="1"
                                                />
                                                <span class="form-check-label fw-semibold">
                                                    Minyak Tanah
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-solid me-10"
                                            >
                                                <input
                                                    class="form-check-input h-20px w-20px"
                                                    type="checkbox"
                                                    v-model="formInput.biomess.description.brekes"
                                                    :value="1"
                                                />
                                                <span class="form-check-label fw-semibold">
                                                    Brekes
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required"> Riwayat PPOK </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="1"
                                                    v-model="formInput.riwayat_ppok.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="0"
                                                    v-model="formInput.riwayat_ppok.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="fv-row mt-4"
                                            v-if="formInput.riwayat_ppok.value == 1"
                                        >
                                            <select
                                                v-model="formInput.riwayat_ppok.description"
                                                class="form-control"
                                            >
                                                <option
                                                    v-for="i in pillihanTahuns"
                                                    :key="i"
                                                    :value="i"
                                                >
                                                    {{ i }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required"> Riwayat TB </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="1"
                                                    v-model="formInput.riwayat_tb.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="0"
                                                    v-model="formInput.riwayat_tb.value"
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>

                                        <div class="row" v-if="formInput.riwayat_tb.value == 1">
                                            <div class="col-sm-6">
                                                <div class="fv-row mt-4 mt-sm-0">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Tahun</span>
                                                    </label>
                                                    <select
                                                        v-model="
                                                            formInput.riwayat_tb.description.tahun
                                                        "
                                                        class="form-control"
                                                    >
                                                        <option
                                                            v-for="i in pillihanTahuns"
                                                            :key="i"
                                                            :value="i"
                                                        >
                                                            {{ i }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="fv-row mt-4 mt-sm-0">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">OAT</span>
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            min="0"
                                                            v-model="
                                                                formInput.riwayat_tb.description.oat
                                                            "
                                                        />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                Bulan
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-dashed mt-4 p-3" style="position: relative">
                                        <label class="form-label fs-6 text-dark">
                                            <span class="required">
                                                Riwayat Keganasan Dalam Keluarga
                                            </span>
                                        </label>
                                        <div class="d-flex align-items-center my-3">
                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="1"
                                                    v-model="
                                                        formInput.riwayat_kaganasan_keluarga.value
                                                    "
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Ada
                                                </span>
                                            </label>

                                            <label
                                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    value="0"
                                                    v-model="
                                                        formInput.riwayat_kaganasan_keluarga.value
                                                    "
                                                />
                                                <span
                                                    class="form-check-label fw-semibold text-gray-500"
                                                >
                                                    Tidak
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="row"
                                            v-if="formInput.riwayat_kaganasan_keluarga.value == 1"
                                        >
                                            <div class="col-sm-5">
                                                <div class="fv-row mt-4 mt-sm-0">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Siapa</span>
                                                    </label>
                                                    <input
                                                        class="form-control"
                                                        type="text"
                                                        autocomplete="off"
                                                        v-model="
                                                            formInput.riwayat_kaganasan_keluarga
                                                                .description.siapa
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="fv-row mt-4 mt-sm-0">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Apa</span>
                                                    </label>
                                                    <input
                                                        class="form-control"
                                                        type="text"
                                                        autocomplete="off"
                                                        v-model="
                                                            formInput.riwayat_kaganasan_keluarga
                                                                .description.apa
                                                        "
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="fv-row mt-4 mt-sm-0">
                                                    <label class="form-label fs-6 text-dark">
                                                        <span class="required">Tahun</span>
                                                    </label>
                                                    <select
                                                        v-model="
                                                            formInput.riwayat_kaganasan_keluarga
                                                                .description.tahun
                                                        "
                                                        class="form-control"
                                                    >
                                                        <option
                                                            v-for="i in pillihanTahuns"
                                                            :key="i"
                                                            :value="i"
                                                        >
                                                            {{ i }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
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
import { computed, ref } from 'vue'

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

const year = new Date().getFullYear()
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
    ],
    penyakits: [
        {
            description: null
        }
    ],
    kategori_perokok: {
        riwayat: 3,
        jumlah: null,
        lama: 0,
        ib: 3,
        kategori: null,
        cara_menghisap: 0
    },
    paparan_asap_rokok: 0,
    pekerjaan_beresiko: {
        value: 0,
        description: null
    },
    tempat_tinggal_sekitar_pabrik: {
        value: 0,
        description: null
    },
    riwayat_keganasan_organ_lain: {
        value: 0,
        description: null
    },
    paparan_radon: {
        value: 0,
        description: {
            rumah_kayu: 0,
            lantai_retak: 0,
            sumur_dalam_rumah: 0
        }
    },
    biomess: {
        value: 0,
        description: {
            kayu_bakar: 0,
            minyak_tanah: 0,
            brekes: 0
        }
    },
    riwayat_ppok: {
        value: 0,
        description: year
    },
    riwayat_tb: {
        value: 0,
        description: {
            tahun: year,
            oat: 0
        }
    },
    riwayat_kaganasan_keluarga: {
        value: 0,
        description: {
            siapa: null,
            apa: null,
            tahun: year
        }
    }
})

const pillihanTahuns = computed((): number[] => {
    const res: number[] = []
    for (let i = 0; i < 10; i++) {
        res.push(year - i)
    }
    return res
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

function tambahPenyakit() {
    formInput.value.penyakits.push({
        description: null
    })
}

function hapusPenyakit(idx: number) {
    formInput.value.penyakits.splice(idx, 1)
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
