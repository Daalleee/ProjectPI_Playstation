<?php

namespace Tests\Feature\Pelanggan;

use App\Models\User;
use App\Models\UnitPS;
use App\Models\Game;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelangganFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $pelanggan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pelanggan = User::factory()->create([
            'role' => 'pelanggan',
            'email' => 'pelanggan@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Test',
        ]);
    }

    public function test_pelanggan_can_view_catalog()
    {
        UnitPS::create([
            'name' => 'PS5 Catalog',
            'stock' => 5,
            'brand' => 'Sony',
            'model' => 'Standard',
            'price_per_hour' => 10000,
            'status' => 'tersedia',
            'nama' => 'PS5 Catalog',
            'merek' => 'Sony',
            'nomor_seri' => 'CAT001',
            'harga_per_jam' => 10000,
            'stok' => 5,
        ]);

        $response = $this->actingAs($this->pelanggan)
            ->get(route('pelanggan.unitps.list'));

        $response->assertStatus(200);
        $response->assertSee('PS5 Catalog');
    }

    public function test_pelanggan_can_add_item_to_cart()
    {
        $unit = UnitPS::create([
            'name' => 'PS5 Cart',
            'stock' => 5,
            'brand' => 'Sony',
            'model' => 'Standard',
            'price_per_hour' => 10000,
            'status' => 'tersedia',
            'nama' => 'PS5 Cart',
            'merek' => 'Sony',
            'nomor_seri' => 'CART001',
            'harga_per_jam' => 10000,
            'stok' => 5,
        ]);

        $response = $this->actingAs($this->pelanggan)
            ->post(route('pelanggan.cart.add'), [
                'type' => 'unitps', // Controller expects 'type'
                'id' => $unit->id,  // Controller expects 'id'
                'quantity' => 1,
                'price_type' => 'per_jam',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('carts', [
            'user_id' => $this->pelanggan->id,
            'type' => 'unitps',
            'item_id' => $unit->id,
            'quantity' => 1,
        ]);
    }

    public function test_pelanggan_can_checkout_cart()
    {
        // 1. Setup Cart
        $unit = UnitPS::create([
            'name' => 'PS5 Checkout',
            'stock' => 5,
            'brand' => 'Sony',
            'model' => 'Standard',
            'price_per_hour' => 10000,
            'status' => 'tersedia',
            'nama' => 'PS5 Checkout',
            'merek' => 'Sony',
            'nomor_seri' => 'CHK001',
            'harga_per_jam' => 10000,
            'stok' => 5,
        ]);

        Cart::create([
            'user_id' => $this->pelanggan->id,
            'type' => 'unitps',
            'item_id' => $unit->id,
            'name' => 'PS5 Checkout',
            'price' => 10000,
            'price_type' => 'per_jam',
            'quantity' => 1,
        ]);

        // Mock MidtransService
        $this->mock(\App\Services\MidtransService::class, function ($mock) {
            $mock->shouldReceive('createSnapToken')->andReturn('dummy-token');
        });

        // 2. Act
        $response = $this->actingAs($this->pelanggan)
            ->post(route('pelanggan.rentals.store'), [
                'rental_date' => now()->addHour()->toDateTimeString(),
                'return_date' => now()->addHour()->addDays(1)->toDateTimeString(), // 1 day duration
                'notes' => 'Test rental',
            ]);

        // 3. Assert
        $response->assertStatus(200); // Should return view 'pelanggan.payment.midtrans'
        $response->assertViewIs('pelanggan.payment.midtrans');
        
        $this->assertDatabaseHas('rentals', [
            'user_id' => $this->pelanggan->id,
            'status' => 'pending', // Initial status before payment
        ]);
        
        // Cart should be empty
        $this->assertDatabaseMissing('carts', [
            'user_id' => $this->pelanggan->id,
        ]);
    }

    public function test_pelanggan_can_view_rental_history()
    {
        // 1. Setup Rental
        $rental = \App\Models\Rental::create([
            'user_id' => $this->pelanggan->id,
            'status' => 'selesai',
            'kode' => 'HIST01',
            'start_at' => now()->subDays(2),
            'due_at' => now()->subDays(1),
        ]);

        // 2. Act
        $response = $this->actingAs($this->pelanggan)
            ->get(route('pelanggan.rentals.index'));

        // 3. Assert
        $response->assertStatus(200);
        $response->assertSee('HIST01');
    }
}
