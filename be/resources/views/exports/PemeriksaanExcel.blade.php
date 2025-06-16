<table>
  <thead>
    <tr>
      <th align="center">No</th>
      <th align="center">Nama Pasien</th>
      <th align="center">No MR</th>
      <th align="center">JenisKelamin</th>
      <th align="center">Umur</th>
      <th align="center">Tanggal Pemeriksaan</th>
      <th align="center">Keluhan Utama</th>
      <th align="center">Lama Keluhan</th>
      <th align="center">Gejala Lainnya</th>
      <th align="center">Riwayat Penyakit</th>
      <th align="center">Keadaan Umum</th>
      <th align="center">Penunjang</th>
      <th align="center">Jenis Sel</th>
      <th align="center">PS</th>
      <th align="center">Mutasi</th>
      <th align="center">PD-L1</th>
      <th align="center">ALK</th>
      <th align="center">Stage</th>
      <th align="center">Paru</th>
      <th align="center">Komorbid</th>
      <th align="center">Staging T</th>
      <th align="center">Staging N</th>
      <th align="center">Staging M</th>
      <th align="center">Tatalaksana</th>
      <th align="center">Tanggal Progress</th>
      <th align="center">Tanggal Kematian</th>
      <th align="center">Sebab Kematian</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($datas as $idx => $item)
      @php
        $pasien = $item->pasien->setAppends(['age']);
        $diagnosa = $item->diagnosa->setAppends(['jenis_sel_text', 'alk_text', 'stage_text', 'paru_text']);
        $outcome = $item->outcome;
        $keluhan = $item->complains->firstWhere('tag', 1);
        $keluhanLainnya = $item->complains->where('tag', '!=', 1);

        
        $tatalaksana = [];
        $sitoglogi = $item->sitologis->whereNotNull('date')->first();
        if($item->operasis->count() > 1) array_push($tatalaksana, "Operasi");
        if($item->kemoterapis->count() > 1) array_push($tatalaksana, "Kemoterapi");
        if($item->terapis->count() > 1) array_push($tatalaksana, "Terapi");
        if(optional($item->radioterapi)->date) array_push($tatalaksana, "Radioterapi");
        if(optional($sitoglogi)->date) array_push($tatalaksana, "PA");

        $penunjangs = [];
        if($item->torakFotos->count() > 1) array_push($penunjangs, "RO. Foto Toraks");
        if($item->torakScans->count() > 1) array_push($penunjangs, "CT-Scan Toraks");
        if($item->boneSurveys->count() > 1) array_push($penunjangs, "Bone Survey");
        if($item->mris->count() > 1) array_push($penunjangs, "MRI");
        if($item->torakUsgs->count() > 1) array_push($penunjangs, "USG Toraks");
        if(optional($item->laboratoryResult)->date) array_push($penunjangs, "Hasil Laboratorium");
        if($item->bronkoskopi->vocal_cords) array_push($penunjangs, "Bronkoskopi");
        if($item->paalParu->kvp_ml) array_push($penunjangs, "PAAL Paru");
        if($item->lainnya->count() > 1) array_push($penunjangs, "Pemeriksaan Lainnya");
      @endphp
      <tr>
        <td>{{ $idx + 1 }}</td>
        <td>{{ $pasien->name }}</td>
        <td>{{ $pasien->no_mr }}</td>
        <td>{{ $pasien->gender ? 'Laki-laki' : 'Perempuan' }}</td>
        <td>{{ $pasien->age }}</td>
        <td>{{ parseDateTimeId($item->inspection_at)->format("Y-m-d") }}</td>
        <td>{{ $keluhan->description }}</td>
        <td>{{ $keluhan->duration }}</td>
        <td>{{ implode(", ", $keluhanLainnya->pluck('description')->toArray()) }}</td>
        <td>Riwayat Penyakit</td>
        <td>Keadaan Umum</td>
        <td>
          {{ implode(", ", $penunjangs) }}
        </td>
        <td>{{ implode(", ", $diagnosa->jenis_sel_text) }}</td>
        <td>{{ implode(", ", is_array($diagnosa->ps) ? $diagnosa->ps : []) }}</td>
        <td>{{ $diagnosa->mutasi }}</td>
        <td>{{ $diagnosa->pdl1 }}</td>
        <td>{{ implode(", ", $diagnosa->alk_text) }}</td>
        <td>{{ implode(", ", $diagnosa->stage_text) }}</td>
        <td>{{ implode(", ", $diagnosa->paru_text) }}</td>
        <td>{{ $diagnosa->komorbid }}</td>
        <td>{{ $diagnosa->staging_t }}</td>
        <td>{{ $diagnosa->staging_m }}</td>
        <td>{{ $diagnosa->staging_n }}</td>
        <td>
          {{ implode(", ", $tatalaksana) }}
        </td>
        <td>{{ parseDateTimeId($outcome->progress)->format("Y-m-d") }}</td>
        <td>{{ parseDateTimeId($outcome->dead)->format("Y-m-d") }}</td>
        <td>{{ $outcome->description }}</td>
      </tr>
    @endforeach
  </tbody>
</table>