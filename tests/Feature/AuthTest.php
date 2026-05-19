<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

test('admin login page is accessible', function () {
    $response = $this->get(route('admin.login'));
    $response->assertStatus(200);
    $response->assertViewIs('admin.login');
});

test('admin dashboard requires authentication', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertRedirect(route('admin.login'));
});

test('authenticated admin can access dashboard', function () {
    $admin = new Admin([
        'username' => 'testadmin',
        'password' => Hash::make('password'),
    ]);
    $admin->adminId = 1;

    $this->actingAs($admin, 'admin');

    $response = $this->get(route('admin.dashboard'));
    $response->assertStatus(200);
});

test('admin login with invalid credentials fails', function () {
    $response = $this->post(route('admin.login.submit'), [
        'username' => 'nobody',
        'password' => 'wrong',
    ]);
    $response->assertSessionHasErrors('username');
});
