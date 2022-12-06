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

    public function exportData(int $reportId, ?DateTime $dateStart, ?DateTime $dateEnd): array
    {
        $report = $this->model::find($reportId);

        if (!$report) {
            return [];
        }

        $sql = $report->sql;

        if (!is_null($dateStart) && is_null($dateEnd)) {
            $sql .= " WHERE t.created_at >= '{$dateStart->format('Y-m-d')}'";
        }

        if (is_null($dateStart) && !is_null($dateEnd)) {
            $sql .= " WHERE t.created_at <= '{$dateEnd->format('Y-m-d')} 23:59:59'";
        }

        if (!is_null($dateStart) && !is_null($dateEnd)) {
            $sql .= " WHERE t.created_at BETWEEN '{$dateStart->format('Y-m-d')}'";
            $sql .= " AND '{$dateEnd->format('Y-m-d')} 23:59:59'";
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
