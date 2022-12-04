<?php

namespace App\Repositories\Eloquent;

use App\Models\Job;
use App\Repositories\Contracts\JobRepositoryInterface;

class JobRepository extends AbstractRepository implements JobRepositoryInterface
{
    protected $model = Job::class;
}
