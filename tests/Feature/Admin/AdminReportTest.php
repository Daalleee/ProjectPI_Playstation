<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReportTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);
    }

    public function test_admin_can_view_report_page_with_correct_stats()
    {
        // 1. Setup Data
        
        // Rental 1: Active, Paid Today
        $rental1 = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'kode' => 'RPT001',
            'start_at' => now(),
            'due_at' => now()->addDays(1),
        ]);
        
        Payment::create([
            'rental_id' => $rental1->id,
            'amount' => 100000,
            'method' => 'cash',
            'paid_at' => now(),
        ]);

        // Rental 2: Returned, Paid Yesterday (Same Month)
        $rental2 = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'selesai',
            'kode' => 'RPT002',
            'start_at' => now()->subDays(1),
            'due_at' => now(),
            'returned_at' => now(),
        ]);

        Payment::create([
            'rental_id' => $rental2->id,
            'amount' => 50000,
            'method' => 'transfer',
            'paid_at' => now()->subDays(1),
        ]);

        // Rental 3: Pending, No Payment
        $rental3 = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'menunggu_konfirmasi',
            'kode' => 'RPT003',
            'start_at' => now(),
        ]);

        // 2. Act
        $response = $this->actingAs($this->admin)
            ->get(route('admin.laporan'));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertSee('Laporan');

        // Verify Revenue Stats passed to view
        // Total Revenue: 100,000 + 50,000 = 150,000
        // Today Revenue: 100,000
        // Month Revenue: 150,000 (assuming test runs in same month)
        
        $response->assertViewHas('revenueTotal', 150000);
        $response->assertViewHas('revenueToday', 100000);
        $response->assertViewHas('revenueMonth', 150000);

        // Verify Rental Counts
        // Total Rentals: 3
        // Active Rentals: 2 (sedang_disewa + menunggu_konfirmasi)
        // Returned Rentals: 1 (selesai)
        
        $response->assertViewHas('rentalsTotal', 3);
        $response->assertViewHas('rentalsActive', 2);
        $response->assertViewHas('rentalsReturned', 1);

        // Verify Latest Payments
        $latestPayments = $response->viewData('latestPayments');
        $this->assertCount(2, $latestPayments);
        $this->assertEquals(100000, $latestPayments[0]->amount); // Most recent first
        $this->assertEquals(50000, $latestPayments[1]->amount);
    }
}
