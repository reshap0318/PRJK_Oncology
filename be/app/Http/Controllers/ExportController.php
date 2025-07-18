<?php

namespace App\Http\Controllers;

use App\Exports\PemeriksaanExcel;
use App\Services\Module\PasienPemeriksaanService;
use App\Services\Module\PemeriksaanBoneSurveyService;
use App\Services\Module\PemeriksaanKemoterapiService;
use App\Services\Module\PemeriksaanMriKepalaService;
use App\Services\Module\PemeriksaanOperasiService;
use App\Services\Module\PemeriksaanRadioterapiService;
use App\Services\Module\PemeriksaanTerapiTargetService;
use App\Services\Module\PemeriksaanToraksFotoService;
use App\Services\Module\PemeriksaanToraksScanService;
use App\Services\Module\PemeriksaanToraksUsgService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    function pemeriksaanPDF($id)
    {
        $payload = (new PasienPemeriksaanService())->getById($id, 'laporan');

        $payload['tatalaksana_operasis'] = (new PemeriksaanOperasiService())->getData(['pemeriksaan_id' => $id])->get()->toArray();
        $payload['tatalaksana_kemoterapis'] = (new PemeriksaanKemoterapiService())->getData(['pemeriksaan_id' => $id])->get()->each->setAppends(['platinum_detail_text', 'combination_detail_text'])->toArray();
        $payload['tatalaksana_radioterapis'] = (new PemeriksaanRadioterapiService())->getData(['pemeriksaan_id' => $id])->get()->each->setAppends(['category_text', 'ct_scan_url'])->toArray();
        $payload['tatalaksana_targets'] = (new PemeriksaanTerapiTargetService())->getData(['pemeriksaan_id' => $id])->get()->each->setAppends(['category_text', 'ct_scan_url'])->toArray();

        $payload['toraks_foto'] = (new PemeriksaanToraksFotoService())->getData(['pemeriksaan_id' => $id])->get()->toArray();
        $payload['toraks_scan'] = (new PemeriksaanToraksScanService())->getData(['pemeriksaan_id' => $id])->get()->toArray();
        $payload['toraks_usg'] = (new PemeriksaanToraksUsgService())->getData(['pemeriksaan_id' => $id])->get()->toArray();

        $payload['bone_survey'] = (new PemeriksaanBoneSurveyService())->getData(['pemeriksaan_id' => $id])->get()->toArray();
        $payload['mri'] = (new PemeriksaanMriKepalaService())->getData(['pemeriksaan_id' => $id])->get()->toArray();
        // dd($payload);

        $pdf = Pdf::loadView('exports.PemeriksaanPDF', ['payload' => $payload]);
        return $pdf->stream('laporan-pemeriksaan-' . $id . '.pdf');
    }

    function pemeriksaanExcel(Request $request)
    {
        $request->validate([
            'dokter'     => 'nullable',
            'startDate' => 'required|date',
            'endDate'   => 'required|date|gte:startDate',
        ]);

        $fileName = "Laporan-Pemeriksaan-" . parseDateTimeId()->format("d-m-Y") . ".xlsx";
        return (new PemeriksaanExcel($request->all()))->download($fileName);
    }
}
