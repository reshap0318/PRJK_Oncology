<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pemeriksaan PDF</title>
  <style>
    .title {
      font-size: 16px; 
      font-weight: 900;
      margin-bottom: 12px;
    }

    .table {
      border-collapse: collapse;
      width: 100%;
    }
    .table th, .table td {
      border: 1px solid black;
      padding: 4px;
    }

    .cover {
      margin-top: 10px; 
      padding-top: 0px;
    }

    .page-break {
        page-break-after: always;
    }
  </style>
</head>
<body>
  <div style="text-align: center;" class="title">DATA PEMERIKSAAN PASIEN</div>
      @php
          $pasien = $payload['overview']['pasien'] ?? [];
          $dokter = $payload['overview']['dokter'] ?? [];
          $anamnesis = $payload['anemnesis'] ?? [];
          $pemeriksaan_fisik = $payload['pemeriksaan_fisik'] ?? [];
          $outcome = $payload['outcome'] ?? [];
          $diagnosa = $payload['diagnosa'] ?? [];
          $bronkoskopi = $payload['bronkoskopi'] ?? [];
          $paalParu = $payload['paal_paru'] ?? [];
          $laboratory = $payload['laboratoryResult'] ?? [];
          $sitologis = $payload['sitologis'] ?? [];
          $torakScan = $payload['toraks_scan'] ?? [];
          $torakFoto = $payload['toraks_foto'] ?? [];
          $torakUsg = $payload['toraks_usg'] ?? [];
          $boneSurvey = $payload['bone_survey'] ?? [];
          $mris = $payload['mri'] ?? [];
      @endphp
  <div class="mt-3">
    <table>
      <tbody>
          <tr>
              <th scope="row" style="width: 170px; text-align: left">Nama Pasien</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['name'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 170px; text-align: left">No MR</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['no_mr'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 170px; text-align: left">Umur</th>
              <td style="width: 10px">:</td>
              <td>000</td>
          </tr>
          <tr>
              <th scope="row" style="width: 170px; text-align: left">Telepon</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['phone'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 170px; text-align: left">Jenis Kelamin</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['gender'] ?? '' }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 170px; text-align: left">Tanggal Pemeriksaan</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $payload['overview']['tanggal'] }}
              </td>
          </tr>
          <tr>
              <th scope="row" style="width: 170px; text-align: left">Alamat</th>
              <td style="width: 10px">:</td>
              <td>
                {{ $pasien['address'] ?? '' }}
              </td>
          </tr>
      </tbody>
    </table>
    <hr style="margin: 5px 4px -20px 4px; padding: 0px">
    <div margin="cover">
      <h5 style="margin-left: 12px" class="title">A. ANEMNESIS</h5>
      <table class="table">
        <tbody>
          <tr>
            <td scope="row" style="width: 170px">Keluhan Utama</td>
            <td>
              {{ $anamnesis['keluhans'][0]['description'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Lama Keluhan (Bulan)</td>
            <td>
              {{ $anamnesis['keluhans'][0]['duration'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Gejala Lainnya</td>
            <td>
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
            <td>
              @php
                  $penyakits = array_merge($anamnesis['penyakit_riwayats'], $anamnesis['penyakits']);
                  foreach ($penyakits as $key => $value) {
                    echo "- ". $value['description'] . "<br />";
                  }
              @endphp
            </td>
          </tr>
          <tr>
            <th scope="row" class="title" style="text-align: left">Faktor Resiko</th>
            <td></td>
          </tr>
          <tr>
            <td scope="row">Riwayat Merokok</td>
            <td>
              {{ $anamnesis['kategori_perokok']['history_text'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Jumlah</td>
            <td>
              {{ $anamnesis['kategori_perokok']['stick_day'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Lama Merokok (Tahun)</td>
            <td>
              {{ $anamnesis['kategori_perokok']['count_year'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">IB</td>
            <td>
              {{ $anamnesis['kategori_perokok']['ib'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Filter</td>
            <td>
              {{ $anamnesis['kategori_perokok']['category_text'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Cara Menghisap</td>
            <td>
              {{ $anamnesis['kategori_perokok']['suck_text'] }}              
            </td>
          </tr>
          <tr>
            <td scope="row">Paparan Asap Rokok Lingkungan</td>
            <td>
              {{ $anamnesis['paparan_asap_rokok']['own'] == 1 ? "Ada [". $anamnesis['paparan_asap_rokok']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Pekerjaan Berisiko</td>
            <td>
              {{ $anamnesis['pekerjaan_beresiko']['own'] == 1 ? "Ada [". $anamnesis['pekerjaan_beresiko']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Tempat Tinggal Disekitar Pabrik</td>
            <td>
              {{ $anamnesis['tempat_tinggal_sekitar_pabrik']['own'] == 1 ? "Ada [". $anamnesis['tempat_tinggal_sekitar_pabrik']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat Keganasan di Organ Lain</td>
            <td>
              {{ $anamnesis['riwayat_keganasan_organ_lain']['own'] == 1 ? "Ada [". $anamnesis['riwayat_keganasan_organ_lain']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Paparan Radon</td>
            <td>
              {{ $anamnesis['paparan_radon']['own'] == 1 ? "Ada [". implode(', ', $anamnesis['paparan_radon']['value_txt']) ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Biomess</td>
            <td>
              {{ $anamnesis['biomess']['own'] == 1 ? "Ada [". implode(', ', $anamnesis['biomess']['value_txt']) ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat PPOK</td>
            <td>
              {{ $anamnesis['riwayat_ppok']['own'] == 1 ? "Ada [". $anamnesis['riwayat_ppok']['value'] ."]" : "Tidak" }}            
            </td>
          </tr>
          <tr>
            <td scope="row">Riwayat TB</td>
            <td>
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
            <td>
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

    <div class="page-break"></div>
    <div margin="cover">
      <h5 style="margin-left: 12px" class="title">B. PEMERIKSAAN FISIK</h5>
      <table class="table">
        <tbody>
          <tr>
            <th scope="row" style="width: 170px; text-align: left" >Tanda Vital</th>
            <td></td>
          </tr>
          <tr>
            <td scope="row">Keadaan Umum</td>
            <td></td>
          </tr>
          <tr>
            <td scope="row">TD (mmHg)</td>
            <td>
              {{ $pemeriksaan_fisik['td'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">RR (kali/menit)</td>
            <td>
              {{ $pemeriksaan_fisik['rr'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">SpO2 (%room air)</td>
            <td>
              {{ $pemeriksaan_fisik['sp_o2'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Nadi (kali/menit)</td>
            <td>
              {{ $pemeriksaan_fisik['nadi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Suhu</td>
            <td>
              {{ $pemeriksaan_fisik['suhu'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">VAS</td>
            <td>
              {{ $pemeriksaan_fisik['vas'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Keterangan</td>
            <td>
              {{ $pemeriksaan_fisik['description'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">KGB</td>
            <td>
              {{ $pemeriksaan_fisik['kgb_option'] == 1 ? "Ya, " . $pemeriksaan_fisik['kgb'] : "Tidak" }}
            </td>
          </tr>
          <tr>
            <th scope="row" style="text-align: left" class="title">Paru</th>
            <td></td>
          </tr>
          <tr>
            <td scope="row">Inspeksi</td>
            <td></td>
          </tr>
          <tr>
            <td scope="row">Statis</td>
            <td>
              {{ $pemeriksaan_fisik['inspeksi_statis'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Dinamis</td>
            <td>
              {{ $pemeriksaan_fisik['inspeksi_dinamis'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Palpasi</td>
            <td>
              {{ $pemeriksaan_fisik['palpasi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Perkusi</td>
            <td>
              {{ $pemeriksaan_fisik['perkusi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Auskultasi</td>
            <td>
              {{ $pemeriksaan_fisik['auskultasi'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Abdomen</td>
            <td>
              {{ $pemeriksaan_fisik['abdomen'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Ekstemitas</td>
            <td>
              {{ $pemeriksaan_fisik['ekstemitas'] }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="page-break"></div>
    <div class="cover">
      <h5 style="margin-left: 12px" class="title">C. PENUNJANG</h5>
      <p style="margin-left: 12px" class="title">1. RADIOLOGI</p>
      <table class="table" style="margin-bottom: 20px">
        <tbody>
          <tr>
            <td style="width: 20px;"></td>
            <td scope="row" style="width: 170px">
              <b>RO.FOTO TORAKS</b>
            </td>
            <td></td>
          </tr>
          @forelse ($torakFoto as $item)
            <tr>
              <td></td>
              <td style="width: 170px">
                Tanggal
              </td>
              <td>{{ $item['date'] }}</td>
            </tr>
            <tr>
              <td></td>
              <td style="width: 170px">
                <b>PA</b>
              </td>
              <td>
                {{ $item['pa_size'] }} - {{ $item['pa_lokasi'] }} - {{ $item['pa_efusi'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td style="width: 170px">
                Keterangan
              </td>
              <td>
                {{ $item['pa_description'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td style="width: 170px">
                <b>Lateral Kanan/Kiri</b>
              </td>
              <td>
                {{ $item['la_size'] }} - {{ $item['la_lokasi'] }} - {{ $item['la_efusi'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td style="width: 170px">
                Keterangan
              </td>
              <td>
                {{ $item['la_description'] }}
              </td>
            </tr>
          @empty
              <tr>
                <td></td>
                <td colspan="2">Tidak Ada Data</td>
              </tr>
          @endforelse
        </tbody>
      </table>
      <table class="table" style="margin-bottom: 20px">
        <tbody>
          <tr>
            <td style="width: 20px;"></td>
            <td style="width: 170px">
              <b>CT-Scan Toraks</b>
            </td>
            <td></td>
          </tr>
          @forelse ($torakScan as $idx => $item)
            <tr>
              <td>{{ $idx + 1 }}</td>
              <td>
                Tanggal
              </td>
              <td>
                {{ $item['date'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                Keterangan
              </td>
              <td>
                {{ $item['description'] }}
              </td>
            </tr>
          @empty
              <tr>
                <td></td>
                <td colspan="2">Tidak Ada Data</td>
              </tr>
          @endforelse
        </tbody>
      </table>
      <table class="table" style="margin-bottom: 20px">
        <tbody>
          <tr>
            <td style="width: 20px;"></td>
            <td scope="row" style="width: 170px">
              <b>Bone Survey</b>
            </td>
            <td></td>
          </tr>
          @forelse ($boneSurvey as $idx => $item)
            <tr>
              <td>{{ $idx + 1 }}</td>
              <td style="width: 170px">
                Tanggal
              </td>
              <td>{{ $item['date'] }}</td>
            </tr>
            <tr>
              <td></td>
              <td style="width: 170px">
                Keterangan
              </td>
              <td>{{ $item['description'] }}</td>
            </tr>
          @empty
              <tr>
                <td></td>
                <td colspan="2">Tidak Ada Data</td>
              </tr>
          @endforelse
        </tbody>
      </table>
      <table class="table" style="margin-bottom: 20px">
        <tbody>
          <tr>
            <td style="width: 20px;"></td>
            <td scope="row" style="width: 170px">
              <b>MRI Kepala</b>
            </td>
            <td></td>
          </tr>
          @forelse ($mris as $idx => $item)
            <tr>
              <td>{{ $idx + 1 }}</td>
              <td style="width: 170px">
                Tanggal
              </td>
              <td>{{ $item['date'] }}</td>
            </tr>
            <tr>
              <td></td>
              <td style="width: 170px">
                Keterangan
              </td>
              <td>{{ $item['description'] }}</td>
            </tr>
          @empty
              <tr>
                <td></td>
                <td colspan="2">Tidak Ada Data</td>
              </tr>
          @endforelse
        </tbody>
      </table>
      <table class="table" style="margin-bottom: 20px">
        <tbody>
          <tr>
            <td style="width: 20px;"></td>
            <td scope="row" style="width: 170px">
              <b>USG Toraks</b>
            </td>
            <td></td>
          </tr>
          @forelse ($torakUsg as $idx => $item)
            <tr>
              <td>{{ $idx + 1 }}</td>
              <td style="width: 170px">
                Tanggal
              </td>
              <td>{{ $item['date'] }}</td>
            </tr>
            <tr>
              <td style="width: 170px">
                Keterangan
              </td>
              <td>{{ $item['description'] }}</td>
            </tr>
          @empty
            <tr>
              <td></td>
              <td colspan="2">Tidak Ada Data</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      {{-- <p style="margin-left: 12px" class="title">2. HASIL LABORATORIUM</p>
      <table class="table">
        <tbody>
          <tr>
            <td scope="row" style="width: 170px">
              Tanggal
            </td>
            <td>-</td>
          </tr>
        </tbody>
      </table> --}}
      <p style="margin-left: 12px" class="title">2. HASIL BRONKOSKOPI</p>
      <table class="table">
        <tbody>
          <tr>
            <td scope="row" style="width: 170px">Pita Suara</td>
            <td>
              {{ $bronkoskopi['vocal_cords'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">Trakea</td>
            <td>
              {{ $bronkoskopi['trachea'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">Carina</td>
            <td>
              {{ $bronkoskopi['carina'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">BUKa</td>
            <td>
              {{ $bronkoskopi['r_bu'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">Second Carina</td>
            <td>
              {{ $bronkoskopi['r_carina_second'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">BUKi</td>
            <td>
              {{ $bronkoskopi['l_bu'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">Second Carina</td>
            <td>
              {{ $bronkoskopi['l_carina_second'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">LAKa/LAKi</td>
            <td>
              {{ $bronkoskopi['l_la'] }}/{{ $bronkoskopi['r_la'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">TI</td>
            <td>
              {{ $bronkoskopi['r_ti'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">Lower Division</td>
            <td>
              {{ $bronkoskopi['l_ld'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">LM</td>
            <td>
              {{ $bronkoskopi['r_lm'] }}
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">LBKa/LBKi</td>
            <td>
              {{ $bronkoskopi['l_lb'] }}/{{ $bronkoskopi['r_lb'] }}
            </td>
          </tr>
        </tbody>
      </table>
      <p style="margin-left: 12px" class="title">3. PA</p>
      <table class="table">
        <tbody>
          @foreach ($sitologis as $sitology)
          <tr>
            <td scope="row" style="width: 170px">
              <b>{{ $sitology['label'] }}</b>
            </td>
            <td></td>
          </tr>
          <tr>
            <td scope="row">
              Tanggal
            </td>
            <td>{{ $sitology['date'] }}</td>
          </tr>
          <tr>
            <td scope="row">
              Jenis Sel Ganas
            </td>
            <td> {{ $sitology['type_text'] }} </td>
          </tr>
          <tr>
            <td scope="row">
              Keterangan
            </td>
            <td> {{ $sitology['description'] }} </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <p style="margin-left: 12px" class="title">4. PAAL PARU</p>
      <table class="table">
        <tbody>
          <tr>
            <td scope="row" style="width: 170px">KVP</td>
            <td>
              {{ $paalParu['kvp_ml'] ?? 0 }}ml {{ $paalParu['kvp_percent'] ?? 0 }}ml 
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">VEP 1</td>
            <td>
              {{ $paalParu['vep_ml'] ?? 0 }}ml {{ $paalParu['vep_percent'] ?? 0 }}% 
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">VEP1/KVP</td>
            <td>
              {{ $paalParu['vep_kvp'] ?? 0 }}% 
            </td>
          </tr>
          <tr>
            <td scope="row" style="width: 170px">Resume</td>
            <td>
              {{ $paalParu['description'] }}
            </td>
          </tr>
        </tbody>
      </table>
      <p style="margin-left: 12px" class="title">5. PEMERIKSAAN LAINNYA</p>
      <table class="table">
        <tbody>
          <tr>
            <td scope="row" style="width: 170px">
              Nama Pemeriksa
            </td>
            <td>-</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="page-break"></div>
    <div class="cover">
      <h5 style="margin-left: 12px" class="title">D. DIAGNOSA</h5>
      <table class="table">
        <tbody>
          <tr>
            <td scope="row" style="width: 170px">Jenis Sel</td>
            <td>
              {{ implode(", ", $diagnosa['jenis_sel_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">PS</td>
            <td>
              {{ implode(", ", $diagnosa['ps'] ?? []) }}
            </td>
          </tr>
          <tr>
            <th scope="row" class="title" style="text-align: left">Marker Molekular (EGFR)</th>
            <td></td>
          </tr>
          <tr>
            <td scope="row">Mutasi</td>
            <td>
              {{ $diagnosa['mutasi'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">PD-L1</td>
            <td>
              {{ $diagnosa['pdl1'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">ALK</td>
            <td>
              {{ implode(", ", $diagnosa['alk_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">Stage</td>
            <td>
              {{ implode(", ", $diagnosa['stage_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">Paru</td>
            <td>
              {{ implode(", ", $diagnosa['paru_text'] ?? []) }}
            </td>
          </tr>
          <tr>
            <td scope="row">Komorbid</td>
            <td>
              {{ $diagnosa['komorbid'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Staging T</td>
            <td>
              {{ $diagnosa['staging_t'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Staging N</td>
            <td>
              {{ $diagnosa['staging_n'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Staging M</td>
            <td>
              {{ $diagnosa['staging_m'] ?? "" }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="page-break"></div>
    <div class="cover">
      <h5 style="margin-left: 12px" class="title">E. TATALAKSANA</h5>
      <p style="margin-left: 12px" class="title">1. Operasi</p>
      <table class="table">
        <tbody>
            @foreach ($payload['tatalaksana_operasis'] as $key => $item)
              <tr>
                <td style="width: 30px" class="title">{{ numberToRomanRepresentation($key + 1) }}</td>
                <td style="width: 170px">Tanggal</td>
                <td>
                  {{ $item['date'] }}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>Dokter</td>
                <td>
                  {{ $item['dokter_name'] }}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>Jenis Operasi</td>
                <td>
                  {{ $item['category'] }}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>Margin</td>
                <td>
                  R{{ implode(", R", $item['margin']) }}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>Resume</td>
                <td>
                  {{ $item['description'] }}
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>

      <p style="margin-left: 12px" class="title">2. Kemoterapi</p>
      @forelse ($payload['tatalaksana_kemoterapis'] as $key => $item)
        <table class="table">
          <tbody>
            <tr>
              <td style="width: 30px" class="title">{{ $key + 1 }}</td>
              <td style="width: 170px">Kemoterapi Lini -</td>
              <td>
                {{ $item['lini'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Date</td>
              <td>
                {{ $item['date'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Jenis Kemoterapi</td>
              <td>
                {{ $item['category_text'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Dosis</td>
              <td>
                {{ $item['dose'] }}
              </td>
            </tr>
          </tbody>
        </table>
      @empty
        <table class="table">
          <tr>
            <td class="title">Tidak Ada Data</td>
          </tr>
        </table>
      @endforelse

      <p style="margin-left: 12px" class="title">3. Radioterapi</p>
      @forelse ($payload['tatalaksana_radioterapis'] as $key => $item)
        <table class="table">
          <tbody>
            <tr>
              <td style="width: 30px" class="title">{{ $key + 1 }}</td>
              <td style="width: 170px">Tanggal Radioterapi</td>
              <td>
                {{ $item['date'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Jenis Radioterapi</td>
              <td>
                {{ $item['category_text'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Dosis</td>
              <td>
                {{ $item['dose'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Fraksi</td>
              <td>
                {{ $item['fraksi'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>CT-Scan Baseline</td>
              <td>
                @if ($item['ct_scan_path'])
                  @if (in_array(pathinfo($item['ct_scan_path'], PATHINFO_EXTENSION), ["jpg", "jpeg", "png"]))
                    <img src="{{ '../storage/app/private/'.$item['ct_scan_path'] }}" alt="" style="width: 150px; height: 150px;">
                  @else 
                    {{ $item['ct_scan_url'] }}
                  @endif
                @endif
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Resume</td>
              <td>
                {{ $item['description'] }}
              </td>
            </tr>
          </tbody>
        </table>
      @empty
        <table class="table">
          <tr>
            <td class="title">Tidak Ada Data</td>
          </tr>
        </table>
      @endforelse

      <p style="margin-left: 12px" class="title">4. Terapi Target</p>
      @forelse ($payload['tatalaksana_targets'] as $key => $item)
        <table class="table">
          <tbody>
            <tr>
              <td style="width: 30px" class="title">{{ $key + 1 }}</td>
              <td style="width: 170px">Tanggal</td>
              <td>
                {{ $item['date'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Jenis Terapi Target</td>
              <td>
                {{ $item['category_text'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Lama (Bulan)</td>
              <td>
                {{ $item['long'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Efek Samping</td>
              <td>
                {{ $item['side_effect'] }}
              </td>
            </tr>
            <tr>
              <td></td>
              <td>CT-Scan Baseline</td>
              <td>
                @if ($item['ct_scan_path'])
                  @if (in_array(pathinfo($item['ct_scan_path'], PATHINFO_EXTENSION), ["jpg", "jpeg", "png"]))
                    <img src="{{ '../storage/app/private/'.$item['ct_scan_path'] }}" alt="" style="width: 150px; height: 150px;">
                  @else 
                    {{ $item['ct_scan_url'] }}
                  @endif
                @endif
              </td>
            </tr>
            <tr>
              <td></td>
              <td>Resume</td>
              <td>
                {{ $item['description'] }}
              </td>
            </tr>
          </tbody>
        </table>
      @empty
        <table class="table">
          <tr>
            <td class="title">Tidak Ada Data</td>
          </tr>
        </table>
      @endforelse
    </div>
    
    <div class="page-break"></div>
    <div class="cover">
      <h5 style="margin-left: 12px" class="title">F. OUTCOME</h5>
      <table class="table">
        <tbody>
          <tr>
            <td scope="row" style="width: 170px">Tanggal Progress</td>
            <td>
              {{ $outcome['progress'] }}
            </td>
          </tr>
          <tr>
            <td scope="row">Tanggal Kematian</td>
            <td>
              {{ $outcome['dead'] ?? "" }}
            </td>
          </tr>
          <tr>
            <td scope="row">Sebab Kematian</td>
            <td>
              {{ $outcome['description'] ?? "" }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="margin-top: 20px;">
      <table style="width: 100%">
        <tr>
          <td style="text-align: right">
            <b>{{ $payload['overview']['perubahan_terakhir'] }}</b> <br />
          </td>
        </tr>
        <tr>
          <td style="text-align: right">
            <b>Dokter yang Merawat</b> <br />
          </td>
        </tr>
        <tr>
          <td style="text-align: right">
            {{ $dokter['name'] }} <br />
          </td>
        </tr>
        <tr>
          <td style="text-align: right">
            {{ $dokter['id'] }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>