<template>
    <BaseModal modalId="pemeriksaan" ref="modal" width="modal-fullscreen">
        <template #title>{{ title }}</template>
        <template #close>
            <div>
                <button class="btn btn-success btn-sm me-3" @click="simpan()">Simpan</button>
                <button class="btn btn-danger btn-sm" @click="cancel()">Batal</button>
            </div>
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
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <template v-if="formActive == 'ONC000'">
                            <FormOverview />
                        </template>
                        <template v-if="formActive == 'ONC001'">
                            <FormAnemnesis />
                        </template>
                        <template v-else-if="formActive == 'ONC002'">
                            <FormPemeriksaanFisik />
                        </template>
                        <template v-else-if="formActive == 'ONC003'">C</template>
                        <template v-else-if="formActive == 'ONC004'">
                            <FormDiagnosa />
                        </template>
                        <template v-else-if="formActive == 'ONC005'">E</template>
                        <template v-else-if="formActive == 'ONC006'">
                            <FormOutcome />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </BaseModal>
</template>

<script lang="ts" setup>
import BaseModal from '@/components/utils/modal/BaseModal.vue'
import FormOverview from './FormOverview.vue'
import FormAnemnesis from './FormAnemnesis.vue'
import FormPemeriksaanFisik from './FormPemeriksaanFisik.vue'
import FormDiagnosa from './FormDiagnosa.vue'
import FormOutcome from './FormOutcome.vue'
import Swal from 'sweetalert2'

import { onMounted, ref } from 'vue'
import { year, usePasienPemeriksaanStore } from '@/stores/module/pasienPemeriksaan'
import { useSelectStore } from '@/stores/global/select'

const pemeriksaanStore = usePasienPemeriksaanStore()
const selectStore = useSelectStore()
const modal = ref()
const title = ref('Tambah Pemeriksaan')
const formActive = ref('ONC000')
const menus = ref([
    {
        code: 'ONC000',
        label: 'Overview'
    },
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

function show(param: any = {}) {
    formActive.value = 'ONC000'
    pemeriksaanStore.formInputValidated.$reset()
    if (param.id) {
        console.log('parse form be')
    } else {
        //overview
        pemeriksaanStore.formInput.overview.dokter_id = null
        pemeriksaanStore.formInput.overview.pasien_id = null
        pemeriksaanStore.formInput.overview.tanggal = null

        //anamnesis
        pemeriksaanStore.formInput.anemnesis.biomess = {
            own: 0,
            value: []
        }
        pemeriksaanStore.formInput.anemnesis.keluhans = [
            {
                description: null,
                long: 0
            }
        ]
        pemeriksaanStore.formInput.anemnesis.gejalas = [
            {
                description: null,
                long: 0
            }
        ]
        pemeriksaanStore.formInput.anemnesis.penyakits = [
            {
                description: null
            }
        ]
        pemeriksaanStore.formInput.anemnesis.kategori_perokok = {
            riwayat: 3,
            jumlah: null,
            lama: null,
            ib: 3,
            jenis_rokok: null,
            cara_menghisap: 0
        }
        pemeriksaanStore.formInput.anemnesis.paparan_asap_rokok = {
            own: 0,
            value: null
        }
        pemeriksaanStore.formInput.anemnesis.pekerjaan_beresiko = {
            own: 0,
            value: null
        }
        pemeriksaanStore.formInput.anemnesis.tempat_tinggal_sekitar_pabrik = {
            own: 0,
            value: null
        }
        pemeriksaanStore.formInput.anemnesis.riwayat_keganasan_organ_lain = {
            own: 0,
            value: null
        }
        pemeriksaanStore.formInput.anemnesis.paparan_radon = {
            own: 0,
            value: []
        }
        pemeriksaanStore.formInput.anemnesis.biomess = {
            own: 0,
            value: []
        }
        pemeriksaanStore.formInput.anemnesis.riwayat_ppok = {
            own: 0,
            value: year
        }
        pemeriksaanStore.formInput.anemnesis.riwayat_tb = {
            own: 0,
            value: {
                tahun: year,
                oat: null
            }
        }
        pemeriksaanStore.formInput.anemnesis.riwayat_kaganasan_keluarga = {
            own: 0,
            value: {
                siapa: null,
                apa: null,
                tahun: year
            }
        }

        //pemeriksaan fisik
        pemeriksaanStore.formInput.pemeriksaan_fisik.abdomen = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.auskultasi = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.description = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.ekstemitas = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.inspeksi_dinamis = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.inspeksi_statis = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.awareness = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.condition = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.kgb = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.kgb_option = 0
        pemeriksaanStore.formInput.pemeriksaan_fisik.nadi = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.palpasi = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.perkusi = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.rr = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.sp_o2 = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.suhu = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.td = null
        pemeriksaanStore.formInput.pemeriksaan_fisik.vas = null

        //diagnosa
        pemeriksaanStore.formInput.diagnosa.jenis_sel = []
        pemeriksaanStore.formInput.diagnosa.paru = []
        pemeriksaanStore.formInput.diagnosa.stage = []
        pemeriksaanStore.formInput.diagnosa.staging = []
        pemeriksaanStore.formInput.diagnosa.ps = []
        pemeriksaanStore.formInput.diagnosa.egfr = null
        pemeriksaanStore.formInput.diagnosa.mutasi = null
        pemeriksaanStore.formInput.diagnosa.whild_type = 0
        pemeriksaanStore.formInput.diagnosa.pdl1 = null
        pemeriksaanStore.formInput.diagnosa.alk = []
        pemeriksaanStore.formInput.diagnosa.komorbid = null

        //outcome
        pemeriksaanStore.formInput.outcome.cara_pulang = null
        pemeriksaanStore.formInput.outcome.keadaan_pulang = null
        pemeriksaanStore.formInput.outcome.lama_dirawat = null
        pemeriksaanStore.formInput.outcome.sebab_kematian = null
        pemeriksaanStore.formInput.outcome.tanggal_meninggal = null
        pemeriksaanStore.formInput.outcome.waktu_meninggal = null
    }
    modal.value.show()
}

function simpan() {
    pemeriksaanStore.formInputValidated.$validate().then((res) => {
        if (res) {
            console.log(pemeriksaanStore.formInput)

            pemeriksaanStore.create(pemeriksaanStore.formInput).then((res: any) => {
                Swal.fire({
                    title: 'Success!',
                    text: res.message,
                    icon: 'success'
                }).then(() => {
                    modal.value.hide()
                })
            })
        } else {
            Swal.fire({
                title: 'Warning!',
                text: 'Form Belum Terisi dengan Lengkap, Silakan Periksa Kembali Form Anda',
                icon: 'warning'
            })
        }
    })
}

function cancel() {
    modal.value.hide()
}

defineExpose({
    show
})

onMounted(() => {
    selectStore.getDokters().then((res: any) => {
        if (res.length == 1) pemeriksaanStore.formInput.overview.dokter_id = res[0].id
    })
    selectStore.getPasiens()
})
</script>

<style>
#modal_pemeriksaan .modal-body {
    --bs-bg-rgb-color: var(--bs-gray-400-rgb);
    background-color: #ebedee;
}
</style>
