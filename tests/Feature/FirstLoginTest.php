<?php

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('student with first login true is redirected to first login page', function () {
    $programStudi = ProgramStudi::create(['nama_prodi' => 'Teknik Informatika']);
    
    $user = User::factory()->create([
        'role_id' => 3,
        'is_first_login' => true,
    ]);
    
    $mahasiswa = Mahasiswa::create([
        'nim' => '123456',
        'nama' => $user->name,
        'program_studi_id' => $programStudi->id,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/mahasiswa/dashboard');

    $response->assertRedirect(route('mahasiswa.first-login'));
});

test('student with first login false is not redirected', function () {
    $programStudi = ProgramStudi::create(['nama_prodi' => 'Teknik Informatika']);
    
    $user = User::factory()->create([
        'role_id' => 3,
        'is_first_login' => false,
    ]);
    
    $mahasiswa = Mahasiswa::create([
        'nim' => '123456',
        'nama' => $user->name,
        'program_studi_id' => $programStudi->id,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/mahasiswa/dashboard');

    $response->assertOk();
    $response->assertViewIs('mahasiswa.dashboard');
});

test('student can complete first login setup', function () {
    $programStudi = ProgramStudi::create(['nama_prodi' => 'Teknik Informatika']);
    
    $user = User::factory()->create([
        'role_id' => 3,
        'is_first_login' => true,
    ]);
    
    $mahasiswa = Mahasiswa::create([
        'nim' => '123456',
        'nama' => $user->name,
        'program_studi_id' => $programStudi->id,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->post('/mahasiswa/first-login', [
        'email' => 'newemail@example.com',
        'whatsapp' => '081234567890',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertRedirect(route('mahasiswa.dashboard'));
    $response->assertSessionHas('success');

    $user->refresh();
    $mahasiswa->refresh();

    expect($user->email)->toBe('newemail@example.com');
    expect($user->is_first_login)->toBeFalse();
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
    expect($mahasiswa->whatsapp)->toBe('081234567890');
});

test('first login setup requires validation', function () {
    $programStudi = ProgramStudi::create(['nama_prodi' => 'Teknik Informatika']);
    
    $user = User::factory()->create([
        'role_id' => 3,
        'is_first_login' => true,
    ]);
    
    $mahasiswa = Mahasiswa::create([
        'nim' => '123456',
        'nama' => $user->name,
        'program_studi_id' => $programStudi->id,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->post('/mahasiswa/first-login', [
        'email' => 'invalid-email',
        'whatsapp' => 'abc',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);

    $response->assertSessionHasErrors(['email', 'whatsapp', 'password']);
    
    $user->refresh();
    expect($user->is_first_login)->toBeTrue();
});
