<?php

namespace Tests\Feature\Kasir;

use App\Models\User;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirDashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    protected $kasir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kasir = User::factory()->create([
            'role' => 'kasir',
            'email' => 'kasir@example.com',
        ]);
    }

    public function test_kasir_dashboard_shows_correct_statistics()
    {
        // 1. Setup Data
        
        // Unpaid Rental (Paid < Total)
        Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'start_at' => now(),
            'total' => 100000,
            'paid' => 50000, // Partial payment
        ]);

        // Fully Paid Active Rental
        Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'start_at' => now(),
            'total' => 100000,
            'paid' => 100000,
        ]);

        // Pending Confirmation (Counts as Active)
        Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'menunggu_konfirmasi',
            'start_at' => now(),
            'total' => 50000,
            'paid' => 50000,
        ]);

        // Completed Today
        Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'selesai',
            'start_at' => now()->subHours(5),
            'returned_at' => now(), // Today
            'total' => 50000,
            'paid' => 50000,
        ]);

        // Completed Yesterday (Should not count for today)
        Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'selesai',
            'start_at' => now()->subDays(2),
            'returned_at' => now()->subDays(1),
            'total' => 50000,
            'paid' => 50000,
        ]);

        // Cancelled (Should not count as unpaid even if paid < total)
        Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'cancelled',
            'start_at' => now(),
            'total' => 100000,
            'paid' => 0,
        ]);

        // 2. Act
        $response = $this->actingAs($this->kasir)
            ->get(route('dashboard.kasir'));

        // 3. Assert
        $response->assertStatus(200);
        
        // Expected Counts:
        // Unpaid: 1 (The first one)
        // Active: 3 (2 sedang_disewa + 1 menunggu_konfirmasi)
        // Completed Today: 1
        
        $response->assertViewHas('unpaidCount', 1);
        $response->assertViewHas('activeCount', 3);
        $response->assertViewHas('completedTodayCount', 1);
        
        $response->assertSee('Belum Lunas');
        $response->assertSee('Sedang Disewa');
        $response->assertSee('Selesai Hari Ini');
    }
}
