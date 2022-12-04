<?php

namespace App\Repositories\Eloquent;

use App\Models\Transfer;
use App\Repositories\Contracts\TransferRepositoryInterface;

class TransferRepository extends AbstractRepository implements TransferRepositoryInterface
{
    protected $model = Transfer::class;
}
