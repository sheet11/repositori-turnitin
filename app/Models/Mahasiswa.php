<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nim',
        'nama',
        'program_studi_id',
        'user_id'
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'user_id', 'user_id');
    }
}
