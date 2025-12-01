<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user to perform actions
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);
    }
    
    public function test_admin_can_view_pemilik_list()
    {
        $pemilik = User::factory()->create([
            'role' => 'pemilik',
            'name' => 'Pemilik Test',
            'email' => 'pemilik@test.com',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.pemilik.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Pemilik');
        $response->assertSee('Pemilik Test');
        $response->assertSee('pemilik@test.com');
    }

    public function test_admin_can_create_pemilik()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.pemilik.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Akun Pemilik');
        $response->assertSee('Nama');
        $response->assertSee('Email');
        $response->assertSee('Password');

        $data = [
            'name' => 'New Pemilik',
            'email' => 'newpemilik@example.com',
            'password' => 'password123',
            'role' => 'pemilik',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.pemilik.store'), $data);

        $response->assertRedirect(route('admin.pemilik.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New Pemilik',
            'email' => 'newpemilik@example.com',
            'role' => 'pemilik',
        ]);
    }

    public function test_admin_can_edit_pemilik()
    {
        $pemilik = User::factory()->create([
            'role' => 'pemilik',
            'name' => 'Old Name',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.pemilik.edit', $pemilik));

        $response->assertStatus(200);
        $response->assertSee('Edit Akun Pemilik');
        $response->assertSee('Old Name');

        $updateData = [
            'name' => 'Updated Name',
            'email' => $pemilik->email,
            'role' => 'pemilik', // Although controller might not use this for update, validation might need it or it's just safe
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.pemilik.update', $pemilik), $updateData);

        $response->assertRedirect(route('admin.pemilik.index'));
        $this->assertDatabaseHas('users', [
            'id' => $pemilik->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_admin_can_delete_pemilik()
    {
        $pemilik = User::factory()->create([
            'role' => 'pemilik',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.pemilik.destroy', $pemilik));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $pemilik->id,
        ]);
    }

    // Kasir Tests
    public function test_admin_can_view_kasir_list()
    {
        $kasir = User::factory()->create([
            'role' => 'kasir',
            'name' => 'Kasir Test',
            'email' => 'kasir@test.com',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.kasir.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Kasir');
        $response->assertSee('Kasir Test');
    }

    public function test_admin_can_create_kasir()
    {
        $data = [
            'name' => 'New Kasir',
            'email' => 'newkasir@example.com',
            'password' => 'password123',
            'role' => 'kasir',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.kasir.store'), $data);

        $response->assertRedirect(route('admin.kasir.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New Kasir',
            'email' => 'newkasir@example.com',
            'role' => 'kasir',
        ]);
    }

    public function test_admin_can_update_kasir()
    {
        $kasir = User::factory()->create([
            'role' => 'kasir',
            'name' => 'Old Kasir',
        ]);

        $updateData = [
            'name' => 'Updated Kasir',
            'email' => $kasir->email,
            'role' => 'kasir',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.kasir.update', $kasir), $updateData);

        $response->assertRedirect(route('admin.kasir.index'));
        $this->assertDatabaseHas('users', [
            'id' => $kasir->id,
            'name' => 'Updated Kasir',
        ]);
    }

    public function test_admin_can_delete_kasir()
    {
        $kasir = User::factory()->create([
            'role' => 'kasir',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.kasir.destroy', $kasir));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $kasir->id,
        ]);
    }

    // Admin Tests (Managing other admins)
    public function test_admin_can_view_admin_list()
    {
        $otherAdmin = User::factory()->create([
            'role' => 'admin',
            'name' => 'Other Admin',
            'email' => 'other@admin.com',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.admin.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Admin');
        $response->assertSee('Other Admin');
    }

    public function test_admin_can_create_admin()
    {
        $data = [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.admin.store'), $data);

        $response->assertRedirect(route('admin.admin.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_update_admin()
    {
        $otherAdmin = User::factory()->create([
            'role' => 'admin',
            'name' => 'Old Admin',
        ]);

        $updateData = [
            'name' => 'Updated Admin',
            'email' => $otherAdmin->email,
            'role' => 'admin',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.admin.update', $otherAdmin), $updateData);

        $response->assertRedirect(route('admin.admin.index'));
        $this->assertDatabaseHas('users', [
            'id' => $otherAdmin->id,
            'name' => 'Updated Admin',
        ]);
    }

    public function test_admin_can_delete_admin()
    {
        $otherAdmin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.admin.destroy', $otherAdmin));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $otherAdmin->id,
        ]);
    }
}
