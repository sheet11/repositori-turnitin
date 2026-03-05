<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Dokumen extends Model
{
    /** @use HasFactory<\Database\Factories\DokumenFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'jenis_dokumen',
        'nim',
        'file_asli',
        'bukti_bayar',
        'tanggal_upload',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function hasilTurnitin()
    {
        return $this->hasOne(HasilTurnitin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
