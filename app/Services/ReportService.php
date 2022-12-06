<?php

namespace App\Services;

use App\Adapter\FileGeneratorAdapterInterface;
use App\Repositories\Contracts\ReportRepositoryInterface;

class ReportService implements ReportServiceInterface
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private FileGeneratorAdapterInterface $csvFileGenerator
    ) {
    }

    public function generateReportFile(array $input): string
    {
        $reportData = $this->reportRepository->exportData(
            $input['reportId'],
            $input['dateStart'],
            $input['dateEnd']
        );

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
