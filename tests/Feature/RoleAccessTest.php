<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->seed();

    $this->admin = User::where('name', 'admin123')->first();
    $this->user = User::where('name', 'user123')->first();
});

test('admin login page is accessible', function () {
    $this->get('/adminlogin')->assertStatus(200);
});

test('admin can login via adminlogin page', function () {
    $response = $this->post('/adminlogin', [
        'name' => 'admin123',
        'password' => '123456',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($this->admin);
});

test('regular user cannot login via adminlogin page', function () {
    $response = $this->post('/adminlogin', [
        'name' => 'user123',
        'password' => '123456',
    ]);

    $response->assertSessionHasErrors('name');
    $this->assertGuest();
});

test('admin can access product CRUD pages', function () {
    $this->actingAs($this->admin);

    $this->get('/dashboard/products')->assertStatus(200);
    $this->get('/dashboard/categories')->assertStatus(200);
    $this->get('/dashboard/products/create')->assertStatus(200);
});

test('regular user cannot access product CRUD pages', function () {
    $this->actingAs($this->user);

    $this->get('/dashboard/products')->assertStatus(403);
    $this->get('/dashboard/categories')->assertStatus(403);
    $this->get('/dashboard/products/create')->assertStatus(403);
});

test('regular user dashboard does not show CRUD links', function () {
    $this->actingAs($this->user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
    $response->assertDontSee('Kelola Produk');
    $response->assertDontSee('Kelola Kategori');
});

test('admin dashboard shows CRUD links', function () {
    $this->actingAs($this->admin);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
    $response->assertSee('Kelola Produk');
    $response->assertSee('Kelola Kategori');
});

test('user can login with username', function () {
    $response = Livewire\Volt\Volt::test('auth.login')
        ->set('username', 'user123')
        ->set('password', '123456')
        ->call('login');

    $response->assertHasNoErrors();
    $this->assertAuthenticatedAs($this->user);
});

test('admin cannot be redirected to admin login when already authenticated as admin', function () {
    $this->actingAs($this->admin);

    $this->get('/adminlogin')->assertRedirect(route('dashboard'));
});
