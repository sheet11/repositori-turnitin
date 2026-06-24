<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $programStudi = \App\Models\ProgramStudi::create([
        'nama_prodi' => 'Teknik Informatika'
    ]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'role_id' => 3,
        'nim' => '123456789',
        'program_studi_id' => $programStudi->id,
        'tahun_angkatan' => 2025,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
