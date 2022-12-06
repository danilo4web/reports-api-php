<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportExportPostRequest;
use App\Services\ReportServiceInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function __construct(
        private ReportServiceInterface $reportService,
    ) {
    }

    public function export(ReportExportPostRequest $request): JsonResponse
    {
        $input = [
            'reportId' => $request->input('id'),
            'dateStart' => $request->input('dateStart')
                ? \DateTime::createFromFormat('Y-m-d', $request->input('dateStart'))
                : null,
            'dateEnd' => $request->input('dateEnd')
                ? \DateTime::createFromFormat('Y-m-d', $request->input('dateEnd'))
                : null,
        ];

        try {
            $reportLink = $this->reportService->generateReportFile($input);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 500);
        }

        $output = ['url' => $reportLink];

        return response()->json($output, 200);
    }

    public function download(string $reportFile): BinaryFileResponse|JsonResponse
    {
        try {
            $filePath = $this->reportService->getFilePath($reportFile);
        } catch (FileNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 500);
        }

        return response()->download($filePath, $reportFile)->deleteFileAfterSend();
    }

    public function create(Request $request): JsonResponse
    {
        $input = $request->all();

        try {
            $this->reportService->createReport($input);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => 'Please check the sql in your payload!'], 500);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 500);
        }

        return response()->json(['message' => 'Report created!'], 201);
    }
}
