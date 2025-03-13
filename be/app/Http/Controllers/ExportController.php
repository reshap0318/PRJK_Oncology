<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    function pemeriksaanPDF($id) {
        // $template = view('exports.PemeriksaanPDF')->render();

        // Browsershot::html($template)
        //     ->noSandbox()
        //     ->showBackground()
        //     ->margins(0, 0, 0, 0)
        //     ->format('A4')
        //     ->save('exports/pemeriksaan.pdf');
        // // return response()->download('exports/pemeriksaan.pdf');
    }
}
