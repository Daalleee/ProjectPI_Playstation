<?php

namespace Tests\Feature\Kasir;

use App\Models\User;
use App\Models\UnitPS;
use App\Models\Rental;
use App\Models\RentalItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirReturnTest extends TestCase
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

    public function test_kasir_can_process_return()
    {
        // 1. Setup Data
        $unit = UnitPS::create([
            'name' => 'PS5 Return Test',
            'stock' => 5,
            'brand' => 'Sony',
            'model' => 'Standard',
            'price_per_hour' => 10000,
            'status' => 'tersedia',
        ]);

        $rental = Rental::create([
            'user_id' => User::factory()->create()->id,
            'status' => 'sedang_disewa',
            'kode' => 'R003',
            'start_at' => now(),
            'due_at' => now()->addDays(1),
        ]);

        $rentalItem = RentalItem::create([
            'rental_id' => $rental->id,
            'rentable_type' => UnitPS::class,
            'rentable_id' => $unit->id,
            'quantity' => 1,
            'price' => 10000,
            'total' => 10000,
        ]);

        // 2. Act
        // Simulate Kasir submitting the return form
        $data = [
            'items' => [
                $rentalItem->id => 1, // Checkbox checked
            ],
            'kondisi' => [
                $rentalItem->id => 'baik',
            ],
        ];

        $response = $this->actingAs($this->kasir)
            ->post(route('kasir.transaksi.pengembalian', $rental), $data);

        // 3. Assert
        $response->assertRedirect(route('kasir.transaksi.index'));
        $response->assertSessionHas('status', 'Pengembalian berhasil dikonfirmasi.');

        // Verify Database Changes
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'status' => 'selesai',
        ]);
        
        $this->assertNotNull(Rental::find($rental->id)->returned_at);

        // Verify Stock Restored
        // Initial 5. Rented 1 (Controller usually decrements on store, but here we created manually so stock remained 5).
        // Wait, if I manually created it with stock 5, and didn't decrement it manually in setup, 
        // then the return controller will INCREMENT it by 1, making it 6.
        // This is fine for testing the increment logic.
        $this->assertDatabaseHas('unit_ps', [
            'id' => $unit->id,
            'stock' => 6, 
        ]);
    }
}
