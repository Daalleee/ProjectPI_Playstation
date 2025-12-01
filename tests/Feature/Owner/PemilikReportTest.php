<?php

namespace Tests\Feature\Owner;

use App\Models\User;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PemilikReportTest extends TestCase
{
    use RefreshDatabase;

    protected $pemilik;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pemilik = User::factory()->create([
            'role' => 'pemilik',
            'email' => 'pemilik@example.com',
        ]);
    }

    public function test_pemilik_can_view_transaction_report_and_filter()
    {
        // 1. Setup Data
        $rental1 = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'selesai',
            'kode' => 'RPT001',
            'start_at' => now()->subDays(5),
            'due_at' => now()->subDays(4),
        ]);

        $rental2 = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'selesai',
            'kode' => 'RPT002',
            'start_at' => now()->subDays(1),
            'due_at' => now(),
        ]);

        // 2. Act - Filter to include only rental2
        $response = $this->actingAs($this->pemilik)
            ->get(route('pemilik.laporan_transaksi', [
                'dari' => now()->subDays(2)->format('Y-m-d'),
                'sampai' => now()->format('Y-m-d'),
            ]));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertSee('RPT002');
        $response->assertDontSee('RPT001');
    }

    public function test_pemilik_can_view_revenue_report_stats()
    {
        // 1. Setup Data
        $rental = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'selesai',
            'kode' => 'REV001',
            'start_at' => now(),
        ]);

        Payment::create([
            'rental_id' => $rental->id,
            'amount' => 100000,
            'method' => 'cash',
            'paid_at' => now(),
        ]);

        Payment::create([
            'rental_id' => $rental->id,
            'amount' => 50000,
            'method' => 'transfer',
            'paid_at' => now()->subDays(10), // Not today, but maybe this month
        ]);

        // 2. Act
        $response = $this->actingAs($this->pemilik)
            ->get(route('pemilik.laporan_pendapatan'));

        // 3. Assert
        $response->assertStatus(200);
        
        // Total Revenue: 150,000
        // Today Revenue: 100,000
        
        // We check if the view receives the correct stats variable structure
        $stats = $response->viewData('revenueStats');
        $this->assertEquals(150000, $stats['total']);
        $this->assertEquals(100000, $stats['today']);
    }
}
