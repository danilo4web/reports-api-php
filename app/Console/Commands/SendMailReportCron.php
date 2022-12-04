<?php

namespace App\Console\Commands;

use App\Mail\OrderError;
use App\Repositories\Contracts\JobRepositoryInterface;
use App\Repositories\Contracts\ReportRepositoryInterface;
use App\Service\FileData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Mail\ReportMail;

class SendMailReportCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:report {reportId} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail Reports';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private JobRepositoryInterface $jobRepository,
        private ReportRepositoryInterface $reportRepository,
        private FileData $fileDataService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info("Cron Job running at " . now());

        $reportId = $this->argument('reportId');
        $email = $this->argument('email');

        try {
            $report = $this->jobRepository->find($reportId);

            if (!$report) {
                Log::error('Report ' . $reportId . ' not found!');
                return 0;
            }

            $reportData = $this->reportRepository->exportData($reportId, null, null);
            $reportLink = $this->fileDataService->createDownloadFile($reportData);
            $emailData = [
                'title' => 'Report Done!',
                'body' => 'Download it here: ' . $reportLink
            ];

            \Mail::to($email)->send(new ReportMail($emailData));

            info("E-mail sent for {$email} at " . now());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return 0;
    }
}
