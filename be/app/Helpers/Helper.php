<?php
use Cron\CronExpression;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

function getUpComingCron($expression) 
{
    return CronExpression::factory($expression)->getNextRunDate()->format('Y-m-d H:i:s');
}

function generateToken(): string
{
    return Str::uuid();
}

function parseDateTimeId(string $date = null) {
    $date = Carbon::parse($date)->locale('id')->timezone(config('app.timezone'));
    $date->settings(['formatFunction' => 'translatedFormat']);
    return $date;
}

function formatRupiah($number = null)
{
    if(!$number) return "Rp. 0";
    $hasil_rupiah = number_format($number,0,',','.');
    return "Rp. ".$hasil_rupiah;
}

function codeGenerate($configArr)
{
    if (!array_key_exists('table', $configArr) || $configArr['table'] == '') {
        throw new Exception('Must need a table name');
    }
    if (!array_key_exists('length', $configArr) || $configArr['length'] == '') {
        throw new Exception('Must specify the length of ID');
    }

    $prefix = $configArr['prefix'] ?? "";
    $field = $configArr['field'] ?? 'id';
    $resetOnPrefixChange = $configArr['reset_on_prefix_change'] ?? false;
    $isAlphabet = $configArr['is_alphabet'] ?? false;

    $prefixLength = strlen($prefix);

    $maxId = DB::table($configArr['table'])
        ->when($resetOnPrefixChange, function($q) use ($field, $prefix)
        {
            return $q->where($field, 'like', $prefix."%");
        })
        ->max($field);

    $idLength = $configArr['length'] - $prefixLength;

    if($isAlphabet) {
        if($maxId != 0) {
            $maxId = substr($maxId, $prefixLength, $idLength);
            $maxId = (int)$maxId != 0 ? 'A' : ++$maxId;
            return $prefix . str_pad($maxId, $idLength, '0', STR_PAD_LEFT);
        }
        return $prefix . str_pad('A', $idLength, '0', STR_PAD_LEFT);
    }
    $maxId = substr($maxId, $prefixLength, $idLength);
    return $prefix . str_pad(++$maxId, $idLength, '0', STR_PAD_LEFT);

}

function summaryHelper($data) {
    return array_merge([
        'bg_color'    => 'bg-c-green',
        'title'       => 'Saldo Awal',
        'nominal'     => 'Rp. 0',
        'icon'        => 'icon-credit-card',
        'created_at'  => parseDateTimeId(now()->toString())->format('l, d-m-Y H:i'),
    ], $data);
}