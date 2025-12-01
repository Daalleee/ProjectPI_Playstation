<?php

namespace Tests\Feature\Kasir;

use App\Models\User;
use App\Models\UnitPS;
use App\Models\Game;
use App\Models\Accessory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirRentalCreationTest extends TestCase
{
    use RefreshDatabase;

    protected $kasir;
    protected $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kasir = User::factory()->create([
            'role' => 'kasir',
            'email' => 'kasir@example.com',
        ]);
        $this->customer = User::factory()->create([
            'role' => 'pelanggan',
        ]);
    }

    public function test_kasir_can_view_create_rental_page()
    {
        $response = $this->actingAs($this->kasir)
            ->get(route('kasir.rentals.create'));

        $response->assertStatus(200);
        $response->assertSee('Buat Transaksi Baru');
        $response->assertSee('Data Pelanggan');
        $response->assertSee('Item Sewa');
    }

    public function test_kasir_can_create_rental_walk_in()
    {
        // 1. Setup Data
        $unit = UnitPS::create([
            'name' => 'PS5 Rental',
            'stock' => 5,
            'brand' => 'Sony',
            'model' => 'Standard',
            'price_per_hour' => 10000,
            'status' => 'tersedia',
            'nama' => 'PS5 Rental',
            'merek' => 'Sony',
            'nomor_seri' => 'PS5001',
            'harga_per_jam' => 10000,
            'stok' => 5,
        ]);

        $game = Game::create([
            'judul' => 'FIFA 2025',
            'stok' => 5,
            'kondisi' => 'baik',
            'platform' => 'PS5',
            'genre' => 'Sports',
            'harga_per_hari' => 50000,
        ]);

        // 2. Act
        $response = $this->actingAs($this->kasir)
            ->post(route('kasir.rentals.store'), [
                'user_id' => $this->customer->id,
                'start_at' => now()->toDateTimeString(),
                'due_at' => now()->addDays(1)->toDateTimeString(),
                'items' => [
                    [
                        'type' => 'unit_ps',
                        'id' => $unit->id,
                        'quantity' => 1,
                        'price' => 10000,
                    ],
                    [
                        'type' => 'game',
                        'id' => $game->id,
                        'quantity' => 1,
                        'price' => 50000,
                    ]
                ],
                'paid' => 60000,
            ]);

        // 3. Assert
        $response->assertRedirect(); // Should redirect to show page
        
        // Verify Rental Created
        $this->assertDatabaseHas('rentals', [
            'user_id' => $this->customer->id,
            'status' => 'sedang_disewa',
            'paid' => 60000,
        ]);

        // Verify Stock Decremented
        $this->assertDatabaseHas('unit_ps', [
            'id' => $unit->id,
            'stock' => 4, // 5 - 1
        ]);

        $this->assertDatabaseHas('games', [
            'id' => $game->id,
            'stok' => 4, // 5 - 1
        ]);
    }
}
