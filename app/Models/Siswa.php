<?php

namespace App\Models;

use App\Traits\HasUuidRamsey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory, HasUuidRamsey;

    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'kelas',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Siswa has many Nilai
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    /**
     * Get average nilai for this siswa
     */
    public function getRataRataAttribute(): float
    {
        return $this->nilai()->avg('nilai') ?? 0;
    }

    /**
     * Get grade based on average nilai
     */
    public function getGradeAttribute(): string
    {
        $rata = $this->rata_rata;

        if ($rata >= 85) return 'A';
        if ($rata >= 70) return 'B';
        if ($rata >= 60) return 'C';
        return 'D';
    }

    /**
     * Scope: Filter by kelas
     */
    public function scopeByKelas($query, string $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    /**
     * Get nilai by mapel
     */
    public function getNilaiByMapel(string $mapel)
    {
        return $this->nilai()->where('mapel', $mapel)->first();
    }
}
