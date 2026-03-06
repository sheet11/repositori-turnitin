<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = [
        'nidn',
        'nama',
    ];

    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        // Assuming we might add dosen_id to users later
        // return $this->hasOne(User::class, 'dosen_id', 'nidn');
    }
}
