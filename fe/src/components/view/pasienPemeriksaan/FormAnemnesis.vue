<template>
    <div class="row">
        <div class="col-12">
            <div class="border-dashed mt-4" style="position: relative">
                <div class="pt-4"></div>
                <div class="row px-3" v-for="(d, i) in formInput.keluhans" :key="i">
                    <div class="col-12 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span> Keluhan Utama </span>
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="keluhan utama"
                                v-model="d.description"
                            />
                            <form-each-error
                                :err="formInputValidated.anemnesis.keluhans"
                                :idx="i"
                                code="description"
                                name="anemnesis.keluhans"
                            />
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span>Lama Keluhan</span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="d.duration"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> Bulan </span>
                                </div>
                            </div>
                            <form-each-error
                                :err="formInputValidated.anemnesis.keluhans"
                                :idx="i"
                                code="duration"
                                name="anemnesis.keluhans"
                            />
                        </div>
                    </div>
                    <div class="col-9" v-if="false">
                        <button
                            class="btn btn-danger mt-8 me-3"
                            v-if="i != 0 || (i == 0 && formInput.keluhans.length > 1)"
                            @click="hapusKeluhan(i)"
                        >
                            Hapus
                        </button>
                        <button
                            class="btn btn-info mt-8 me-3"
                            v-if="i == formInput.keluhans.length - 1"
                            @click="tambahKeluhan"
                        >
                            Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="border-dashed mt-4" style="position: relative">
                <div class="pt-4"></div>
                <div class="row px-3" v-for="(d, i) in formInput.gejalas" :key="i">
                    <div class="col-12 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span>Gejala Lainnya</span>
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                autocomplete="off"
                                placeholder="gejala lainnya"
                                v-model="d.description"
                            />
                            <form-each-error
                                :err="formInputValidated.anemnesis.gejalas"
                                :idx="i"
                                code="description"
                                name="anemnesis.gejalas"
                            />
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span>Lama Keluhan</span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    placeholder="0"
                                    v-model="d.duration"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> Bulan </span>
                                </div>
                            </div>
                            <form-each-error
                                :err="formInputValidated.anemnesis.gejalas"
                                :idx="i"
                                code="duration"
                                name="anemnesis.gejalas"
                            />
                        </div>
                    </div>
                    <div class="col-9">
                        <button
                            v-if="i != 0 || (i == 0 && formInput.gejalas.length > 1)"
                            class="btn btn-danger mt-8 me-3"
                            @click="hapusGejala(i)"
                        >
                            Hapus
                        </button>
                        <button
                            class="btn btn-info mt-8 me-3"
                            v-if="i == formInput.gejalas.length - 1"
                            @click="tambahGejala"
                        >
                            Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="border-dashed mt-4" style="position: relative">
                <div class="pt-4">
                    <div class="row px-3" v-for="(d, i) in formInput.penyakit_riwayats" :key="i">
                        <div class="col-12 mb-3">
                            <label class="form-label fs-6 text-dark">
                                <span>Riwayat Penyakit Dahulu</span>
                            </label>
                            <div class="form-control" v-html="d.description"></div>
                        </div>
                    </div>
                    <div class="row px-3" v-for="(d, i) in formInput.penyakits" :key="i">
                        <div class="col-12 col-sm-10 mb-3">
                            <div class="fv-row">
                                <label class="form-label fs-6 text-dark">
                                    <span>Riwayat Penyakit</span>
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="penyakit"
                                    v-model="d.description"
                                />
                                <form-each-error
                                    :err="formInputValidated.anemnesis.penyakits"
                                    :idx="i"
                                    code="description"
                                    name="anemnesis.penyakits"
                                />
                            </div>
                        </div>
                        <div class="col-12 col-sm-2 mb-3">
                            <button
                                class="btn btn-danger mt-8 me-3"
                                v-if="i != 0 || (i == 0 && formInput.penyakits.length > 1)"
                                @click="hapusPenyakit(i)"
                            >
                                Hapus
                            </button>
                            <button
                                class="btn btn-info mt-8 me-3"
                                style="margin-left: -3px"
                                v-if="i == formInput.penyakits.length - 1"
                                @click="tambahPenyakit()"
                            >
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h2 class="text-uppercase mt-4">Faktor Risiko</h2>
            <div class="border-dashed mt-2 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span>Riwayat Merokok</span>
                </label>
                <div class="d-flex align-items-center">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="1"
                            v-model="formInput.kategori_perokok.history"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Perokok </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="2"
                            v-model="formInput.kategori_perokok.history"
                        />
                        <span class="form-check-label fw-semibold text-gray-500">
                            Bekas Perokok
                        </span>
                    </label>

                    <label class="form-check form-check-custom form-check-solid cursor-pointer">
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="3"
                            v-model="formInput.kategori_perokok.history"
                        />
                        <span class="form-check-label fw-semibold text-gray-500">
                            Bukan Perokok
                        </span>
                    </label>
                </div>
                <div class="row mt-5" v-if="[1, 2].includes(formInput.kategori_perokok.history)">
                    <div class="col-sm-3 mb-3" v-if="formInput.kategori_perokok.history == 1">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span>Jumlah</span>
                            </label>
                            <input
                                class="form-control"
                                type="number"
                                min="0"
                                autocomplete="off"
                                placeholder="batang / hari"
                                v-model="formInput.kategori_perokok.stick_day"
                            />
                            <form-error
                                :err="formInputValidated.anemnesis.kategori_perokok.stick_day"
                                name="anemnesis.kategori_perokok.stick_day"
                            />
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3">
                        <div class="fv-row">
                            <label class="form-label fs-6 text-dark">
                                <span> Lama Merokok (Tahun) </span>
                            </label>
                            <input
                                class="form-control"
                                type="number"
                                min="0"
                                autocomplete="off"
                                placeholder="tahun"
                                v-model="formInput.kategori_perokok.count_year"
                            />
                            <form-error
                                :err="formInputValidated.anemnesis.kategori_perokok.count_year"
                                name="anemnesis.kategori_perokok.count_year"
                            />
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3" v-if="formInput.kategori_perokok.history == 1">
                        <div class="d-flex align-items-center mt-12">
                            <label class="form-label fs-6 text-dar ms-12 me-7 mb-0">
                                <span>IB</span>
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
                                <span class="form-check-label fw-semibold text-gray-500"> R </span>
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
                                <span class="form-check-label fw-semibold text-gray-500"> S </span>
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
                                <span class="form-check-label fw-semibold text-gray-500"> B </span>
                            </label>
                        </div>
                        <form-error
                            :err="formInputValidated.anemnesis.kategori_perokok.ib"
                            name="anemnesis.kategori_perokok.ib"
                        />
                    </div>

                    <div class="col-sm-3 mb-3" v-if="formInput.kategori_perokok.history == 1">
                        <select v-model="formInput.kategori_perokok.category" class="form-control">
                            <option :value="null">Jenis Rokok</option>
                            <option value="1">Kretek</option>
                            <option value="2">Filter</option>
                            <option value="3">Cigar</option>
                        </select>
                        <form-error
                            :err="formInputValidated.anemnesis.kategori_perokok.category"
                            name="anemnesis.kategori_perokok.category"
                        />
                    </div>

                    <div class="col-sm-9 mb-3" v-if="formInput.kategori_perokok.history == 1">
                        <div class="d-flex align-items-center mt-3">
                            <label class="form-label fs-6 text-dar me-7 mb-0">
                                <span>Cara Menghisap</span>
                            </label>

                            <label
                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                            >
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    :value="1"
                                    v-model="formInput.kategori_perokok.suck"
                                />
                                <span class="form-check-label fw-semibold text-gray-500">
                                    Dalam
                                </span>
                            </label>

                            <label
                                class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                            >
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    :value="0"
                                    v-model="formInput.kategori_perokok.suck"
                                />
                                <span class="form-check-label fw-semibold text-gray-500">
                                    Tidak Dalam
                                </span>
                            </label>
                        </div>
                        <form-error
                            :err="formInputValidated.anemnesis.kategori_perokok.suck"
                            name="anemnesis.kategori_perokok.suck"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Paparan Asap Rokok Lingkungan </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="1"
                            v-model="formInput.paparan_asap_rokok.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="0"
                            v-model="formInput.paparan_asap_rokok.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <div class="fv-row mt-4" v-if="formInput.paparan_asap_rokok.own == 1">
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="keterangan"
                        v-model="formInput.paparan_asap_rokok.value"
                    />
                    <form-error
                        :err="formInputValidated.anemnesis.paparan_asap_rokok.value"
                        name="anemnesis.paparan_asap_rokok.value"
                    />
                </div>
            </div>

            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Pekerjaan Beresiko </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="1"
                            v-model="formInput.pekerjaan_beresiko.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="0"
                            v-model="formInput.pekerjaan_beresiko.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <div class="fv-row mt-4" v-if="formInput.pekerjaan_beresiko.own == 1">
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="keterangan"
                        v-model="formInput.pekerjaan_beresiko.value"
                    />
                    <form-error
                        :err="formInputValidated.anemnesis.pekerjaan_beresiko.value"
                        name="anemnesis.pekerjaan_beresiko.value"
                    />
                </div>
            </div>

            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Tempat Tinggal Disekitar Pabrik </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="1"
                            v-model="formInput.tempat_tinggal_sekitar_pabrik.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ya </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="0"
                            v-model="formInput.tempat_tinggal_sekitar_pabrik.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <div class="fv-row mt-4" v-if="formInput.tempat_tinggal_sekitar_pabrik.own == 1">
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="keterangan"
                        v-model="formInput.tempat_tinggal_sekitar_pabrik.value"
                    />
                    <form-error
                        :err="formInputValidated.anemnesis.tempat_tinggal_sekitar_pabrik.value"
                        name="anemnesis.tempat_tinggal_sekitar_pabrik.value"
                    />
                </div>
            </div>

            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark my-3">
                    <span> Riwayat Keganasan di Organ Lain </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="1"
                            v-model="formInput.riwayat_keganasan_organ_lain.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="0"
                            v-model="formInput.riwayat_keganasan_organ_lain.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <div class="fv-row mt-4" v-if="formInput.riwayat_keganasan_organ_lain.own == 1">
                    <input
                        class="form-control"
                        type="text"
                        autocomplete="off"
                        placeholder="keterangan"
                        v-model="formInput.riwayat_keganasan_organ_lain.value"
                    />
                    <form-error
                        :err="formInputValidated.anemnesis.riwayat_keganasan_organ_lain.value"
                        name="anemnesis.riwayat_keganasan_organ_lain.value"
                    />
                </div>
            </div>

            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Paparan Radon </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="1"
                            v-model="formInput.paparan_radon.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            :value="0"
                            v-model="formInput.paparan_radon.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>

                <div
                    class="d-flex align-items-center mt-6 mb-3"
                    v-if="formInput.paparan_radon.own == 1"
                >
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            v-model="formInput.paparan_radon.value"
                            :value="1"
                        />
                        <span class="form-check-label fw-semibold"> Rumah Kayu </span>
                    </label>
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            v-model="formInput.paparan_radon.value"
                            :value="2"
                        />
                        <span class="form-check-label fw-semibold"> Lantai Retak </span>
                    </label>
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            v-model="formInput.paparan_radon.value"
                            :value="3"
                        />
                        <span class="form-check-label fw-semibold"> Sumur Dalam Rumah </span>
                    </label>
                </div>
            </div>
            <form-error
                :err="formInputValidated.anemnesis.paparan_radon.value"
                name="anemnesis.paparan_radon.value"
            />
        </div>
        <div class="col-12 col-sm-6">
            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Biomess </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="1"
                            v-model="formInput.biomess.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="0"
                            v-model="formInput.biomess.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <div class="d-flex align-items-center mt-6 mb-3" v-if="formInput.biomess.own == 1">
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            v-model="formInput.biomess.value"
                            :value="1"
                        />
                        <span class="form-check-label fw-semibold"> Kayu Bakar </span>
                    </label>
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            v-model="formInput.biomess.value"
                            :value="2"
                        />
                        <span class="form-check-label fw-semibold"> Minyak Tanah </span>
                    </label>
                    <label class="form-check form-check-custom form-check-solid me-10">
                        <input
                            class="form-check-input h-20px w-20px"
                            type="checkbox"
                            v-model="formInput.biomess.value"
                            :value="3"
                        />
                        <span class="form-check-label fw-semibold"> Breket </span>
                    </label>
                </div>
                <form-error
                    :err="formInputValidated.anemnesis.biomess.value"
                    name="anemnesis.biomess.value"
                />
            </div>

            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Riwayat PPOK </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="1"
                            v-model="formInput.riwayat_ppok.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="0"
                            v-model="formInput.riwayat_ppok.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <div class="fv-row mt-4" v-if="formInput.riwayat_ppok.own == 1">
                    <select v-model="formInput.riwayat_ppok.value" class="form-control">
                        <option v-for="i in pillihanTahuns" :key="i" :value="i">
                            {{ i }}
                        </option>
                    </select>
                    <form-error
                        :err="formInputValidated.anemnesis.riwayat_ppok.value"
                        name="anemnesis.riwayat_ppok.value"
                    />
                </div>
            </div>

            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Riwayat TB </span>
                </label>
                <div class="d-flex align-items-center my-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="1"
                            v-model="formInput.riwayat_tb.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="0"
                            v-model="formInput.riwayat_tb.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>

                <div class="row" v-if="formInput.riwayat_tb.own == 1">
                    <div class="col-sm-6">
                        <div class="fv-row mt-4 mt-sm-0">
                            <label class="form-label fs-6 text-dark">
                                <span>Tahun</span>
                            </label>
                            <select v-model="formInput.riwayat_tb.value.tahun" class="form-control">
                                <option v-for="i in pillihanTahuns" :key="i" :value="i">
                                    {{ i }}
                                </option>
                            </select>
                            <form-error
                                :err="formInputValidated.anemnesis.riwayat_tb.value.tahun"
                                name="anemnesis.riwayat_tb.value.tahun"
                            />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="fv-row mt-4 mt-sm-0">
                            <label class="form-label fs-6 text-dark">
                                <span>OAT</span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    v-model="formInput.riwayat_tb.value.oat"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text"> Bulan </span>
                                </div>
                            </div>
                            <form-error
                                :err="formInputValidated.anemnesis.riwayat_tb.value.oat"
                                name="anemnesis.riwayat_tb.value.oat"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-dashed mt-4 p-3" style="position: relative">
                <label class="form-label fs-6 text-dark">
                    <span> Riwayat Keganasan Dalam Keluarga </span>
                </label>
                <div class="d-flex align-items-center mt-3">
                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="1"
                            v-model="formInput.riwayat_kaganasan_keluarga.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Ada </span>
                    </label>

                    <label
                        class="form-check form-check-custom form-check-solid cursor-pointer me-10"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            value="0"
                            v-model="formInput.riwayat_kaganasan_keluarga.own"
                        />
                        <span class="form-check-label fw-semibold text-gray-500"> Tidak </span>
                    </label>
                </div>
                <div class="row" v-if="formInput.riwayat_kaganasan_keluarga.own == 1">
                    <div class="col-12">
                        <div
                            class="row"
                            v-for="(d, i) in formInput.riwayat_kaganasan_keluarga.value ?? []"
                        >
                            <div class="mt-3 col-sm-8">
                                <div class="fv-row mt-4 mt-sm-0">
                                    <label class="form-label fs-6 text-dark">
                                        <span>Siapa</span>
                                    </label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        autocomplete="off"
                                        v-model="d.siapa"
                                    />
                                    <form-each-error
                                        :err="
                                            formInputValidated.anemnesis.riwayat_kaganasan_keluarga
                                                .value
                                        "
                                        :idx="i"
                                        code="siapa"
                                        name="anemnesis.riwayat_kaganasan_keluarga.value"
                                    />
                                </div>
                            </div>
                            <div class="mt-3 col-sm-4">
                                <div class="mt-9">
                                    <button
                                        class="btn btn-sm btn-danger me-2"
                                        v-if="
                                            i != 0 ||
                                            (i == 0 &&
                                                formInput.riwayat_kaganasan_keluarga.value?.length >
                                                    1)
                                        "
                                        @click="hapusRiwayatKeluarga(i)"
                                    >
                                        Hapus
                                    </button>
                                    <button
                                        class="btn btn-sm btn-info"
                                        v-if="
                                            i ==
                                            formInput.riwayat_kaganasan_keluarga.value?.length - 1
                                        "
                                        @click="tambahRiwayatKeluarga"
                                    >
                                        Tambah
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3 col-sm-8">
                                <div class="fv-row mt-4 mt-sm-0">
                                    <label class="form-label fs-6 text-dark">
                                        <span>Apa</span>
                                    </label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        autocomplete="off"
                                        v-model="d.apa"
                                    />
                                    <form-each-error
                                        :err="
                                            formInputValidated.anemnesis.riwayat_kaganasan_keluarga
                                                .value
                                        "
                                        :idx="i"
                                        code="apa"
                                        name="anemnesis.riwayat_kaganasan_keluarga.value"
                                    />
                                </div>
                            </div>
                            <div class="mt-3 col-sm-4">
                                <div class="fv-row mt-4 mt-sm-0">
                                    <label class="form-label fs-6 text-dark">
                                        <span>Tahun</span>
                                    </label>
                                    <select v-model="d.tahun" class="form-control">
                                        <option v-for="i in pillihanTahuns" :key="i" :value="i">
                                            {{ i }}
                                        </option>
                                    </select>
                                    <form-each-error
                                        :err="
                                            formInputValidated.anemnesis.riwayat_kaganasan_keluarga
                                                .value
                                        "
                                        :idx="i"
                                        code="tahun"
                                        name="anemnesis.riwayat_kaganasan_keluarga.value"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import FormEachError from '@/components/utils/error/FormEachError.vue'
import FormError from '@/components/utils/error/FormError.vue'

import { computed, ref } from 'vue'
import { year, usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'

const pemeriksaanStore = usePasienPemeriksaanStore()

const formInput = ref(pemeriksaanStore.formUpdate.anemnesis)
const formInputValidated = ref(pemeriksaanStore.formUpdateValidated)

const pillihanTahuns = computed((): number[] => {
    const res: number[] = []
    while (year - res.length > 1900) {
        res.push(year - res.length)
    }
    return res
})

function tambahKeluhan() {
    formInput.value.keluhans.push({
        id: 0,
        description: null,
        duration: null
    })
}

function hapusKeluhan(idx: number) {
    formInput.value.keluhans.splice(idx, 1)
}

function tambahGejala() {
    formInput.value.gejalas.push({
        id: 0,
        description: null,
        duration: null
    })
}

function hapusGejala(idx: number) {
    formInput.value.gejalas.splice(idx, 1)
}

function tambahRiwayatKeluarga() {
    formInput.value.riwayat_kaganasan_keluarga.value.push({
        siapa: null,
        apa: null,
        tahun: null
    })
}

function hapusRiwayatKeluarga(idx: number) {
    formInput.value.riwayat_kaganasan_keluarga.value.splice(idx, 1)
}

function tambahPenyakit() {
    formInput.value.penyakits.push({
        id: 0,
        description: null
    })
}

function hapusPenyakit(idx: number) {
    formInput.value.penyakits.splice(idx, 1)
}
</script>
