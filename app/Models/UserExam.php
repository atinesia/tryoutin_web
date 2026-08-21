<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    protected $fillable = [
        'score_twk',
        'score_tiu',
        'score_tkp',
    ];

    protected $guarded = ['id'];

    // SANGAT PENTING: Ubah kolom tanggal menjadi Carbon Datetime Instance
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'is_passed' => 'boolean',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
