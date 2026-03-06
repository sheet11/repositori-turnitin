<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nim',
        'nama',
        'program_studi_id',
    ];

    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->hasOne(User::class, 'mahasiswa_id', 'nim');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
