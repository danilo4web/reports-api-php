<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportExportPostRequest;
use App\Repositories\Contracts\ReportRepositoryInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Service\FileData;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private FileData $fileDataService,
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
            $reportData = $this->reportRepository->exportData(
                $input['reportId'],
                $input['dateStart'],
                $input['dateEnd']
            );

            if (count($reportData) === 0) {
                throw new \DomainException('No data found!');
            }
            $reportLink = $this->fileDataService->createDownloadFile($reportData);
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
            $fileExists = Storage::disk('public')->exists('reports/' . $reportFile);

            if (!$fileExists) {
                throw new FileNotFoundException('File not found! The download link is valid only one time!');
            }

            $file = Storage::disk('public')->path('reports/' . $reportFile);
        } catch (FileNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 500);
        }

        return response()->download($file, $reportFile)->deleteFileAfterSend();
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->all();

        try {
            $this->reportRepository->store($data);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => 'Please check the sql in your payload!'], 500);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Something went wrong!'], 500);
        }

        return response()->json(['message' => 'Report created!'], 201);
    }
}
