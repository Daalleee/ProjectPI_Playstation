<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\UnitPS;
use App\Models\Game;
use App\Models\Accessory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMasterDataTest extends TestCase
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

    // --- Unit PS Tests ---
    public function test_admin_can_create_unit_ps()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.unitps.store'), [
                'nama' => 'PS5 Pro',
                'merek' => 'Sony',
                'model' => 'Pro',
                'nomor_seri' => 'PS5PRO001',
                'harga_per_jam' => 15000,
                'stok' => 5,
                'status' => 'Tersedia',
            ]);

        $response->assertRedirect(route('admin.unitps.index'));
        $this->assertDatabaseHas('unit_ps', [
            'name' => 'PS5 Pro',
            'serial_number' => 'PS5PRO001',
            'stock' => 5,
        ]);
    }

    public function test_admin_can_update_unit_ps()
    {
        $unit = UnitPS::create([
            'name' => 'PS4 Slim',
            'brand' => 'Sony',
            'model' => 'Slim',
            'serial_number' => 'PS4SLIM001',
            'price_per_hour' => 8000,
            'stock' => 3,
            'status' => 'Tersedia',
            // Fill Indonesian fields for controller compatibility during update validation unique check if needed
            'nama' => 'PS4 Slim',
            'merek' => 'Sony',
            'nomor_seri' => 'PS4SLIM001',
            'harga_per_jam' => 8000,
            'stok' => 3,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.unitps.update', $unit), [
                'nama' => 'PS4 Slim Updated',
                'merek' => 'Sony',
                'model' => 'Slim',
                'nomor_seri' => 'PS4SLIM001',
                'harga_per_jam' => 9000,
                'stok' => 4,
                'status' => 'Tersedia',
            ]);

        $response->assertRedirect(route('admin.unitps.index'));
        $this->assertDatabaseHas('unit_ps', [
            'id' => $unit->id,
            'name' => 'PS4 Slim Updated',
            'price_per_hour' => 9000,
            'stock' => 4,
        ]);
    }

    public function test_admin_can_delete_unit_ps()
    {
        $unit = UnitPS::create([
            'name' => 'PS3 Fat',
            'brand' => 'Sony',
            'model' => 'Fat',
            'serial_number' => 'PS3FAT001',
            'price_per_hour' => 5000,
            'stock' => 1,
            'status' => 'Tersedia',
            'nama' => 'PS3 Fat',
            'merek' => 'Sony',
            'nomor_seri' => 'PS3FAT001',
            'harga_per_jam' => 5000,
            'stok' => 1,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.unitps.destroy', $unit));

        $response->assertRedirect(route('admin.unitps.index'));
        $this->assertDatabaseMissing('unit_ps', ['id' => $unit->id]);
    }

    // --- Game Tests ---
    public function test_admin_can_create_game()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.games.store'), [
                'judul' => 'God of War',
                'platform' => 'PS5',
                'genre' => 'Action',
                'stok' => 10,
                'harga_per_hari' => 40000,
            ]);

        $response->assertRedirect(route('admin.games.index'));
        $this->assertDatabaseHas('games', [
            'judul' => 'God of War',
            'stok' => 10,
        ]);
    }

    // --- Accessory Tests ---
    public function test_admin_can_create_accessory()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.accessories.store'), [
                'nama' => 'HDMI Cable',
                'jenis' => 'Cable',
                'stok' => 20,
                'harga_per_hari' => 5000,
            ]);

        $response->assertRedirect(route('admin.accessories.index'));
        $this->assertDatabaseHas('accessories', [
            'nama' => 'HDMI Cable',
            'stok' => 20,
        ]);
    }

    // --- Pelanggan Tests ---
    public function test_admin_can_create_pelanggan()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.pelanggan.store'), [
                'name' => 'New Customer',
                'email' => 'customer@gmail.com', // Regex requires @gmail.com
                'password' => 'password123',
                'address' => 'Jl. Test No. 1',
                'phone' => '+6281234567890',
            ]);

        $response->assertRedirect(route('admin.pelanggan.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New Customer',
            'email' => 'customer@gmail.com',
            'role' => 'pelanggan',
        ]);
    }
}
