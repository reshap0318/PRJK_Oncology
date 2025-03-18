<?php

namespace App\Http\Controllers;

use App\Services\Module\PasienPemeriksaanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class ExportController extends Controller
{
    function pemeriksaanPDF($id)
    {
        $payload = (new PasienPemeriksaanService())->getById($id, 'laporan');

        return view('exports.PemeriksaanPDF', ['payload' => $payload]);
        $template = view('exports.PemeriksaanPDF', ['payload' => $payload])->render();

        Storage::disk('local')->makeDirectory('exports');
        $dir = Storage::disk('local')->path('exports');
        $path = $dir . '/pemeriksaan.pdf';

        Browsershot::html($template)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->margins(20, 18, 20, 18)
            ->format('A4')
            ->save($path);

        return view('exports.PemeriksaanPDF', ['payload' => $payload]);
        // return response()->download('exports/pemeriksaan.pdf');
    }
}
