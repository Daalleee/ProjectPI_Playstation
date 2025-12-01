<?php

namespace Tests\Feature\Owner;

use App\Models\User;
use App\Models\UnitPS;
use App\Models\Game;
use App\Models\Accessory;
use App\Models\Rental;
use App\Models\RentalItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PemilikStatusTest extends TestCase
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

    public function test_pemilik_can_view_status_page()
    {
        // 1. Setup Data
        $unit = UnitPS::create([
            'name' => 'PS5 Rental',
            'stock' => 1,
            'brand' => 'Sony',
            'model' => 'Standard',
            'price_per_hour' => 10000,
            'status' => 'tersedia',
        ]);

        $game = Game::create([
            'judul' => 'FIFA 2025',
            'stok' => 1,
            'kondisi' => 'baik',
            'platform' => 'PS5',
            'genre' => 'Sports',
            'harga_per_hari' => 50000,
        ]);

        // Create a rental to make them "Sedang Disewa"
        // Note: The controller logic checks if the item ID is in the list of rented items from active rentals.
        // It doesn't strictly check stock count for the status badge, but rather if the specific ID is in the active rental items list.
        // Wait, the controller logic:
        // $unitpsRented = RentalItem::where('rentable_type', UnitPS::class)->whereIn('rental_id', $activeRentalIds)->pluck('rentable_id')->toArray();
        // @php $isRented = in_array($unit->id, $unitpsRented); @endphp
        // This logic implies if ANY unit of this ID is rented, it shows "Sedang Disewa". 
        // Even if stock > 0? Yes, based on the view logic `@if($isRented)`.
        // This might be a slight logic flaw if we have multiple stock, but for verification I will follow the existing logic.
        
        $rental = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'kode' => 'R002',
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
        ]);

        RentalItem::create([
            'rental_id' => $rental->id,
            'rentable_type' => Game::class,
            'rentable_id' => $game->id,
            'quantity' => 1,
            'price' => 50000,
            'total' => 50000,
        ]);

        // 2. Act
        $response = $this->actingAs($this->pemilik)
            ->get(route('pemilik.status_produk'));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertSee('Status Unit & Produk');
        $response->assertSee('PS5 Rental');
        $response->assertSee('FIFA 2025');
        
        // Assert Status Badges
        // Since they are in an active rental, they should show "Sedang Disewa"
        $response->assertSee('Sedang Disewa');
    }
}
