<?php

namespace App\Repositories\Contracts;

use DateTime;

interface ReportRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function store(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function exportData(int $reportId, ?DateTime $dateStart, ?DateTime $dateEnd): array;
}
