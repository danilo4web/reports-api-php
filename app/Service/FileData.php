<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class FileData
{
    public function createDownloadFile(array $data): string
    {
        $csvArrayData = self::transformCsvArrayData($data);

        $csv = fopen('php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+');

        foreach ($csvArrayData as $line) {
            fputcsv($csv, $line, ';');
        }

        rewind($csv);
        $output = stream_get_contents($csv);

        $fileName = 'report_' . time() . '.csv';
        Storage::disk('public')->put('reports/' . $fileName, $output);

        return URL::to('/api/v1/reports/download') . '/' . $fileName;
    }

    private function transformCsvArrayData(array $data): array
    {
        $csvHeader = array_keys((array)$data[0]);
        $csvContent = array_map(fn($row): array => array_values((array)$row), $data);

        return array_merge([$csvHeader], $csvContent);
    }
}
