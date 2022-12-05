<?php

namespace Tests\App\Http\Controllers\API;

use App\Models\Report;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->report = Report::factory()->create([
            'sql' => 'select u.name, t.amount, t.created_at from users u inner join transfers t on u.id = t.user_id',
        ]);
        $this->transfer = Transfer::factory()->create();
    }

    public function testShouldNotCreateReportIfNotLoggedIn()
    {
        $input = [
            'sql' => 'select u.name, t.amount, t.created_at from users u inner join transfers t on u.id = t.user_id'
        ];

        $this->postJson("/api/v1/reports", $input)
            ->assertStatus(401);
    }

    public function testShouldNotCreateReportIfQueryDoesNotWork()
    {
        $this->actingAs($this->user);

        $input = [
            'sql' => 'select u.namee, t.amount, t.created_at from users u inner join transfers t on u.id = t.user_id'
        ];

        $this->postJson("/api/v1/reports", $input)
            ->assertStatus(500)
            ->assertJson(['message' => 'Please check the sql in your payload!']);
    }

    public function testShouldCreateNewReport()
    {
        $this->actingAs($this->user);

        $input = [
            'sql' => 'select u.name, t.amount, t.created_at from users u inner join transfers t on u.id = t.user_id'
        ];

        $this->postJson("/api/v1/reports", $input)
            ->assertStatus(201)
            ->assertJson(['message' => 'Report created!']);
    }

    public function testShouldNotExportReportIfNotLoggedIn()
    {
        $input = [
            'id' => '10',
            'dateStart' => '2022-12-01',
            'dateEnd' => '2022-12-30'
        ];

        $this->postJson("/api/v1/reports/export", $input)
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testShouldExportReportIfEverythingIsOk()
    {
        $this->actingAs($this->user);

        $input = [
            'id' => '1',
            'dateStart' => '2022-12-01',
            'dateEnd' => '2022-12-30'
        ];

        $this->postJson("/api/v1/reports/export", $input)
            ->assertStatus(200)
            ->assertJsonStructure(['url']);
    }
}
