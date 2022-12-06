<?php

namespace App\Adapter;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CsvFileGeneratorAdapter implements FileGeneratorAdapterInterface
{
    public function createDownloadFile(string $storage, array $reportData): string
    {
        $csvArrayData = self::transformCsvArrayData($reportData);

        $csv = fopen('php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+');

        foreach ($csvArrayData as $line) {
            fputcsv($csv, $line, ';');
        }

        rewind($csv);
        $output = stream_get_contents($csv);

        $fileName = 'report_' . time() . '.csv';
        Storage::disk($storage)->put('reports/' . $fileName, $output);

        return URL::to('/api/v1/reports/download') . '/' . $fileName;
    }

    private function transformCsvArrayData(array $data): array
    {
        $csvHeader = array_keys((array)$data[0]);
        $csvContent = array_map(fn($row): array => array_values((array)$row), $data);

        return array_merge([$csvHeader], $csvContent);
    }

    public function getFilePath(string $storage, string $directory, string $file): string
    {
        $fileExists = Storage::disk($storage)->exists($directory . '/' . $file);

        if (!$fileExists) {
            throw new FileNotFoundException('File not found! The download link is valid only one time!');
        }

        return Storage::disk($storage)->path($directory . '/' . $file);
    }
}
