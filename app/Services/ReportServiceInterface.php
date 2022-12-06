<?php

namespace App\Services;

interface ReportServiceInterface
{
    public function generateReportFile(array $input): string;

    public function getFilePath(string $fileName): string;

    public function createReport(array $data): void;
}
