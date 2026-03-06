<?php

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can register as mahasiswa', function () {
    // Create program studi first
    $programStudi = \App\Models\ProgramStudi::create([
        'nama_prodi' => 'Teknik Informatika'
    ]);

    $response = $this->post('/register', [
        'name' => 'Test Mahasiswa',
        'email' => 'mahasiswa@test.com',
        'role_id' => 3,
        'nim' => '12345678',
        'program_studi_id' => $programStudi->id,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');

    $this->assertDatabaseHas('users', [
        'name' => 'Test Mahasiswa',
        'email' => 'mahasiswa@test.com',
        'role_id' => 3,
        'mahasiswa_id' => '12345678',
    ]);

    $this->assertDatabaseHas('mahasiswas', [
        'nim' => '12345678',
        'nama' => 'Test Mahasiswa',
        'program_studi_id' => $programStudi->id,
    ]);
});
