<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pemeriksaan PDF</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="text-center fw-bold">DATA PEMERIKSAAN PASIEN</div>
      @php
          $pasien = $payload['overview']['pasien'] ?? [];
          $dokter = $payload['overview']['dokter'] ?? [];
          $anamnesis = $payload['anemnesis'] ?? [];
          $pemeriksaan_fisik = $payload['pemeriksaan_fisik'] ?? [];
          $outcome = $payload['outcome'] ?? [];
          $diagnosa = $payload['diagnosa'] ?? [];
          $bronkoskopi = $payload['bronkoskopi'] ?? [];
          $paalParu = $payload['paal_paru'] ?? [];
      @endphp
  <div class="mt-3">
    {{-- table table-borderless table-sm --}}
    <table class="">
      <tbody>
          <tr>
              <th scope="row" style="width: 200px">Nama Pasien</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['name'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 200px">No MR</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['no_mr'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 200px">Umur</th>
              <td style="width: 10px">:</td>
              <td>000</td>
          </tr>
          <tr>
              <th scope="row" style="width: 200px">Telepon</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['phone'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 200px">Jenis Kelamin</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['gender'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 200px">Tanggal Pemeriksaan</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $payload['overview']['tanggal'] }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 200px">Alamat</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['address'] ?? '' }}
              </td>
          </tr>
      </tbody>
    </table>
    <hr>
    <div class="mt-3">
      <h5 class="ms-3">A. ANEMNESIS</h5>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">Keluhan Utama</td>
            <td class="align-top">
              {{ $anamnesis['keluhans'][0]['description'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Lama Keluhan (Bulan)</td>
            <td class="align-top">
              {{ $anamnesis['keluhans'][0]['duration'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Gejala Lainnya</td>
            <td class="align-top">
              @php
                  $gejalas = $anamnesis['gejalas'];
                  foreach ($gejalas as $key => $value) {
                    echo "- ". $value['description'] . " ( ". $value['duration'] ." Bulan ) " . "<br />";
                  }
              @endphp
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat Penyakit</td>
            <td class="align-top">
              @php
                  $penyakits = array_merge($anamnesis['penyakit_riwayats'], $anamnesis['penyakits']);
                  foreach ($penyakits as $key => $value) {
                    echo "- ". $value['description'] . "<br />";
                  }
              @endphp
            </td>
          </tr>
          <tr>
            <th scope="row">Faktor Resiko</th>
            <td class="align-top"></td>
          </tr>
          <tr>
            <td scope="row">Riwayat Merokok</td>
            <td class="align-top">
              {{ $anamnesis['kategori_perokok']['history_text'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Jumlah</td>
            <td class="align-top">
              {{ $anamnesis['kategori_perokok']['stick_day'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Lama Merokok (Tahun)</td>
            <td class="align-top">
              {{ $anamnesis['kategori_perokok']['count_year'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">IB</td>
            <td class="align-top">
              {{ $anamnesis['kategori_perokok']['ib'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Filter</td>
            <td class="align-top">
              {{ $anamnesis['kategori_perokok']['category_text'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Cara Menghisap</td>
            <td class="align-top">
              {{ $anamnesis['kategori_perokok']['suck_text'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Paparan Asap Rokok Lingkungan</td>
            <td class="align-top">
              {{ $anamnesis['paparan_asap_rokok']['own'] == 1 ? "Ada [". $anamnesis['paparan_asap_rokok']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Pekerjaan Berisiko</td>
            <td class="align-top">
              {{ $anamnesis['pekerjaan_beresiko']['own'] == 1 ? "Ada [". $anamnesis['pekerjaan_beresiko']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Tempat Tinggal Disekitar Pabrik</td>
            <td class="align-top">
              {{ $anamnesis['tempat_tinggal_sekitar_pabrik']['own'] == 1 ? "Ada [". $anamnesis['tempat_tinggal_sekitar_pabrik']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat Keganasan di Organ Lain</td>
            <td class="align-top">
              {{ $anamnesis['riwayat_keganasan_organ_lain']['own'] == 1 ? "Ada [". $anamnesis['riwayat_keganasan_organ_lain']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Paparan Radon</td>
            <td class="align-top">
              {{ $anamnesis['paparan_radon']['own'] == 1 ? "Ada [". implode(', ', $anamnesis['paparan_radon']['value_txt']) ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Biomess</td>
            <td class="align-top">
              {{ $anamnesis['biomess']['own'] == 1 ? "Ada [". implode(', ', $anamnesis['biomess']['value_txt']) ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat PPOK</td>
            <td class="align-top">
              {{ $anamnesis['riwayat_ppok']['own'] == 1 ? "Ada [". $anamnesis['riwayat_ppok']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat TB</td>
            <td class="align-top">
              @php
                  if($anamnesis['riwayat_tb']['own'] == 1) {
                    echo "Ada <br />";
                    foreach ($anamnesis['riwayat_tb']['value'] as $key => $value) {
                      echo "- ". $value['tahun'] ." ". $value['oat'] . "<br />";
                    }
                  }
                  else {
                    echo "Tidak";
                  }
              @endphp        
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat Keganasan Dalam Keluarga</td>
            <td class="align-top">
              @php
                  if($anamnesis['riwayat_kaganasan_keluarga']['own'] == 1) {
                    echo "Ada <br />";
                    foreach ($anamnesis['riwayat_kaganasan_keluarga']['value'] as $key => $value) {
                      echo "- ". $value['siapa'] ." ". $value['apa'] . " " . $value['tahun'] . "<br />";
                    }
                  }
                  else {
                    echo "Tidak";
                  }
              @endphp         
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      <h5 class="ms-3">B. PEMERIKSAAN FISIK</h5>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <th scope="row" style="width: 200px">Tanda Vital</th>
            <td class="align-top"></td>
          </tr>
          <tr>
            <td scope="row">Ra</td>
            <td class="align-top"></td>
          </tr>
          <tr>
            <td scope="row">Keadaan Umum</td>
            <td class="align-top"></td>
          </tr>
          <tr>
            <td scope="row">TD (mmHg)</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['td'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">RR (kali/menit)</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['rr'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">SpO2 (%room air)</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['sp_o2'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Nadi (kali/menit)</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['nadi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Suhu</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['suhu'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">VAS</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['vas'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Keterangan</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['description'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">KGB</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['kgb_option'] == 1 ? "Ya, " . $pemeriksaan_fisik['kgb'] : "Tidak" }}
            </td>
          </tr>
          <tr>
            <th scope="row">Paru</th>
            <td class="align-top"></td>
          </tr>
          <tr>
            <td scope="row">Inspeksi</td>
            <td class="align-top"></td>
          </tr>
          <tr>
            <td scope="row">Statis</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['inspeksi_statis'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Dinamis</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['inspeksi_dinamis'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Palpasi</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['palpasi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Perkusi</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['perkusi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Auskultasi</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['auskultasi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Abdomen</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['abdomen'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Ekstemitas</td>
            <td class="align-top">
              {{ $pemeriksaan_fisik['ekstemitas'] }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      <h5 class="ms-3">D. DIAGNOSA</h5>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">Jenis Sel</td>
            <td class="align-top">
              {{ implode(", ", $diagnosa['jenis_sel_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">PS</td>
            <td class="align-top">
              {{ implode(", ", $diagnosa['ps'] ?? []) }}
            </td>
          </tr>
          <tr>
            <th scope="row">Marker Molekular (EGFR)</th>
            <td class="align-top"></td>
          </tr>
          <tr>
            <td scope="row">Mutasi</td>
            <td class="align-top">
              {{ $diagnosa['mutasi'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">PD-L1</td>
            <td class="align-top">
              {{ $diagnosa['pdl1'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">ALK</td>
            <td class="align-top">
              {{ implode(", ", $diagnosa['alk_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">Stage</td>
            <td class="align-top">
              {{ implode(", ", $diagnosa['stage_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">Paru</td>
            <td class="align-top">
              {{ implode(", ", $diagnosa['paru_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">Komorbid</td>
            <td class="align-top">
              {{ $diagnosa['komorbid'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Staging T</td>
            <td class="align-top">
              {{ $diagnosa['staging_t'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Staging N</td>
            <td class="align-top">
              {{ $diagnosa['staging_n'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Staging M</td>
            <td class="align-top">
              {{ $diagnosa['staging_m'] ?? "" }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      <p class="ms-3 fw-bold">D. DIAGNOSA</p>
      <p class="ms-3 fw-bold">1. RADIOLOGI</p>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">
              <b>RO.FOTO TORAKS</b>
            </td>
            <td class="align-top">-</td>
          </tr>
        </tbody>
      </table>
      <p class="ms-3 fw-bold mt-3">2. HASIL LABORATORIUM</p>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">
              Tanggal
            </td>
            <td class="align-top">-</td>
          </tr>
        </tbody>
      </table>
      <p class="ms-3 fw-bold mt-3">3. HASIL BRONKOSKOPI</p>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">Pita Suara</td>
            <td class="align-top">
              {{ $bronkoskopi['vocal_cords'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">Trakea</td>
            <td class="align-top">
              {{ $bronkoskopi['trachea'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">Carina</td>
            <td class="align-top">
              {{ $bronkoskopi['carina'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">BUKa</td>
            <td class="align-top">
              {{ $bronkoskopi['r_bu'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">Second Carina</td>
            <td class="align-top">
              {{ $bronkoskopi['r_carina_second'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">BUKi</td>
            <td class="align-top">
              {{ $bronkoskopi['l_bu'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">Second Carina</td>
            <td class="align-top">
              {{ $bronkoskopi['l_carina_second'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">LAKa/LAKi</td>
            <td class="align-top">
              {{ $bronkoskopi['l_la'] }}/{{ $bronkoskopi['r_la'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">TI</td>
            <td class="align-top">
              {{ $bronkoskopi['r_ti'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">Lower Division</td>
            <td class="align-top">
              {{ $bronkoskopi['l_ld'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">LM</td>
            <td class="align-top">
              {{ $bronkoskopi['r_lm'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">LBKa/LBKi</td>
            <td class="align-top">
              {{ $bronkoskopi['l_lb'] }}/{{ $bronkoskopi['r_lb'] }}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="ms-3 fw-bold mt-3">4. HASIL LABORATORIUM</p>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">
              Tanggal
            </td>
            <td class="align-top">-</td>
          </tr>
        </tbody>
      </table>
      <p class="ms-3 fw-bold mt-3">5. PAAL PARU</p>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">KVP</td>
            <td class="align-top">
              {{ $paalParu['kvp_ml'] ?? 0 }}ml {{ $paalParu['kvp_percent'] ?? 0 }}ml 
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">VEP 1</td>
            <td class="align-top">
              {{ $paalParu['vep_ml'] ?? 0 }}ml {{ $paalParu['vep_percent'] ?? 0 }}% 
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">VEP1/KVP</td>
            <td class="align-top">
              {{ $paalParu['vep_kvp'] ?? 0 }}% 
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 200px">Resume</td>
            <td class="align-top">
              {{ $paalParu['description'] }}
            </td>
          </tr>
        </tbody>
      </table>
      <p class="ms-3 fw-bold mt-3">6. PEMERIKSAAN LAINNYA</p>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">
              Nama Pemeriksa
            </td>
            <td class="align-top">-</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      <h5 class="ms-3">E. TATALAKSANA</h5>
      @foreach ($payload['tatalaksana_operasis'] as $key => $item)
        <table class="table table-bordered table-sm mb-3">
          <tbody>
            <tr>
              <td scope="row" style="width: 200px">
                <b>Operasi {{ $key + 1 }}</b>
              </td>
              <td class="align-top"></td>
            </tr>
            <tr>
              <td scope="row">Tanggal</td>
              <td class="align-top">
                {{ $item['date'] }}
              </td>
            </tr>
            <tr>
              <td scope="row">Dokter</td>
              <td class="align-top">
                {{ $item['dokter_name'] }}
              </td>
            </tr>
            <tr>
              <td scope="row">Jenis Operasi</td>
              <td class="align-top">
                {{ $item['category'] }}
              </td>
            </tr>
            <tr>
              <td scope="row">Margin</td>
              <td class="align-top">
                R{{ implode(", R", $item['margin']) }}
              </td>
            </tr>
            <tr>
              <td scope="row">Resume</td>
              <td class="align-top">
                {{ $item['description'] }}
              </td>
            </tr>
          </tbody>
        </table>
      @endforeach
    </div>
    
    <div class="mt-3">
      <h5 class="ms-3">F. OUTCOME</h5>
      <table class="table table-bordered table-sm">
        <tbody>
          <tr>
            <td scope="row" style="width: 200px">Tanggal Progress</td>
            <td class="align-top">
              {{ $outcome['progress'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Tanggal Kematian</td>
            <td class="align-top">
              {{ $outcome['dead'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Sebab Kematian</td>
            <td class="align-top">
              {{ $outcome['description'] ?? "" }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-3 text-end">
      <b>{{ $payload['overview']['perubahan_terakhir'] }}</b> <br />
      <b>Dokter yang Merawat</b> <br />
      {{ $dokter['name'] }} <br />
      {{ $dokter['id'] }}
    </div>
  </div>
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>
</html>