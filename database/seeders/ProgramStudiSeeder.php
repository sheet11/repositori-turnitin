<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programStudis = [
            'D3 Keperawatan',
            'D3 Kebidanan',
            'D3 Gizi',
            'D3 Farmasi',
            'D3 Sanitasi',
            'D3 TLM',
            'Str Keperawatan',
            'Str Kebidanan',
            'Str Gizi',
            'Profesi Ners',
            'Profesi Bidan',
        ];

        foreach ($programStudis as $prodi) {
            ProgramStudi::firstOrCreate([
                'nama_prodi' => $prodi
            ]);
        }
    }
}
