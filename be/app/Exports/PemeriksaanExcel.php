<?php

namespace App\Exports;

use App\Repository\Module\PasienPemeriksaanRepository;
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
        $data = $this->data();

        return view('exports.PemeriksaanExcel', [
            'datas' => $data
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]]
        ];
    }

    public function data()
    {
        $data = (new PasienPemeriksaanRepository())->laporanExcel($this->payload)->get();
        return $data;
    }
}
