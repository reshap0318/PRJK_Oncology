<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\{
    FromView,
    Exportable,
    ShouldAutoSize,
    WithStyles
};

class PemeriksaanExcel implements FromView, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $payload;
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    public function view(): View
    {
        return view('exports.PemeriksaanExcel', [
            
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]
        ];
    }

    // public function data()
    // {
    //     $date = $this->payload['date'] ?? now()->format("Y-m-d");
    //     $kas = $this->payload['kas_code'] ?? "0301";

    //     $datas = (new KasTransactionRepository())->withAkun()->withKas()->filterByPeriodeBulan($date)->filterByKasCode($kas)->get();
    //     return $datas;
    // }

    // public function saldo()
    // {
    //     $date = $this->payload['date'] ?? now()->format("Y-m-d");
    //     $kas = $this->payload['kas_code'] ?? "0301";

    //     $saldo = (new KasTransactionRepository())->getSaldo()->filterByPeriodeSebelumBulan($date)->filterByKasCode($kas)->first();
    //     return $saldo;
    // }
}
