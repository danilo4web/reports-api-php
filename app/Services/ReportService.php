<?php

namespace App\Services;

use App\Adapter\FileGeneratorAdapterInterface;
use App\Repositories\Contracts\ReportRepositoryInterface;

class ReportService
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private FileGeneratorAdapterInterface $csvFileGenerator
    ) {
    }

    public function generateReportFile(array $reportInputDto): string
    {
        $reportData = $this->reportRepository->exportData($reportInputDto);

        if (count($reportData) === 0) {
            throw new \DomainException('No data found!');
        }
        return $this->csvFileGenerator->createDownloadFile('public', $reportData);
    }

    public function getFilePath(string $fileName): string
    {
        return $this->csvFileGenerator->getFilePath('public', 'reports', $fileName);
    }

    public function createReport(array $data): void
    {
        $this->reportRepository->store($data);
    }
}
