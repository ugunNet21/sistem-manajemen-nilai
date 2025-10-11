<?php

namespace App\Models;

use App\Traits\HasUuidRamsey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory, HasUuidRamsey;

    protected $table = 'nilai';
    
    protected $fillable = [
        'siswa_id',
        'kelas',
        'mapel',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Nilai belongs to Siswa
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Get grade based on nilai
     */
    public function getGradeAttribute(): string
    {
        if ($this->nilai >= 85) return 'A';
        if ($this->nilai >= 70) return 'B';
        if ($this->nilai >= 60) return 'C';
        return 'D';
    }

    /**
     * Scope: Filter by mapel
     */
    public function scopeByMapel($query, string $mapel)
    {
        return $query->where('mapel', $mapel);
    }

    /**
     * Scope: Filter by kelas
     */
    public function scopeByKelas($query, string $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    /**
     * Scope: Filter by grade
     */
    public function scopeByGrade($query, string $grade)
    {
        return match($grade) {
            'A' => $query->where('nilai', '>=', 85),
            'B' => $query->whereBetween('nilai', [70, 84]),
            'C' => $query->whereBetween('nilai', [60, 69]),
            'D' => $query->where('nilai', '<', 60),
            default => $query,
        };
    }
}
