<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Report::factory()->create([
            'sql' => 'select u.name, t.amount, t.created_at from users u inner join transfers t on u.id = t.user_id',
        ]);
    }
}
