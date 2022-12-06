<?php

namespace App\Repositories\Eloquent;

use App\Models\Report;
use App\Repositories\Contracts\ReportRepositoryInterface;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReportRepository extends AbstractRepository implements ReportRepositoryInterface
{
    protected string $model = Report::class;

    public function store(array $data)
    {
        $this->checkSqlHealthy($data['sql']);
        parent::store($data);
    }

    public function exportData(array $reportInputDto): array
    {
        $report = $this->model::find($reportInputDto['reportId']);

        if (!$report) {
            return [];
        }

        $sql = $report->sql;

        if (!is_null($reportInputDto['dateStart']) && is_null($reportInputDto['dateEnd'])) {
            $sql .= " WHERE t.created_at >= '{$reportInputDto['dateStart']->format('Y-m-d')}'";
        }

        if (is_null($reportInputDto['dateStart']) && !is_null($reportInputDto['dateEnd'])) {
            $sql .= " WHERE t.created_at <= '{$reportInputDto['dateEnd']->format('Y-m-d')} 23:59:59'";
        }

        if (!is_null($reportInputDto['dateStart']) && !is_null($reportInputDto['dateEnd'])) {
            $sql .= " WHERE t.created_at BETWEEN '{$reportInputDto['dateStart']->format('Y-m-d')}'";
            $sql .= " AND '{$reportInputDto['dateEnd']->format('Y-m-d')} 23:59:59'";
        }

        return DB::select(DB::raw($sql));
    }

    public function checkSqlHealthy(string $sql): void
    {
        try {
            DB::select(DB::raw($sql));
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }
}
