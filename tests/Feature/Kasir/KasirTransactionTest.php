<?php

namespace Tests\Feature\Kasir;

use App\Models\User;
use App\Models\Rental;
use App\Models\UnitPS;
use App\Models\RentalItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirTransactionTest extends TestCase
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

    public function test_kasir_can_view_transaction_list()
    {
        // 1. Setup Data
        $rental1 = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'kode' => 'TRX001',
            'start_at' => now(),
            'due_at' => now()->addDays(1),
            'total' => 100000,
        ]);

        $rental2 = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'selesai',
            'kode' => 'TRX002',
            'start_at' => now()->subDays(2),
            'due_at' => now()->subDays(1),
            'total' => 50000,
        ]);

        // 2. Act
        $response = $this->actingAs($this->kasir)
            ->get(route('kasir.transaksi.index'));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertSee('TRX001');
        $response->assertSee('TRX002');
        $response->assertSee('Daftar Semua Transaksi');
    }

    public function test_kasir_can_search_transaction_by_code()
    {
        // 1. Setup Data
        $rental = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'kode' => 'SEARCH', // Max 6 chars
            'start_at' => now(),
            'due_at' => now()->addDays(1),
        ]);

        // 2. Act
        $response = $this->actingAs($this->kasir)
            ->get(route('kasir.transaksi.index', ['rental_kode' => 'SEARCH']));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertSee('Transaksi ditemukan');
        $response->assertSee('#SEARCH');
    }

    public function test_kasir_can_view_transaction_detail()
    {
        // 1. Setup Data
        $unit = UnitPS::create([
            'name' => 'PS5 Detail Test',
            'stock' => 1,
            'brand' => 'Sony',
            'model' => 'Standard',
            'price_per_hour' => 10000,
            'status' => 'tersedia',
        ]);

        $rental = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'kode' => 'DET001', // Max 6 chars
            'start_at' => now(),
            'due_at' => now()->addDays(1),
        ]);

        RentalItem::create([
            'rental_id' => $rental->id,
            'rentable_type' => UnitPS::class,
            'rentable_id' => $unit->id,
            'quantity' => 1,
            'price' => 10000,
            'total' => 10000,
            'duration' => 1,
        ]);

        // 2. Act
        $response = $this->actingAs($this->kasir)
            ->get(route('kasir.transaksi.show', $rental));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertSee('DET001');
        $response->assertSee('PS5 Detail Test');
    }
}
