<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Relasi ke Sesi Pengerjaan Peserta (UserExam)
     */
    public function userExams()
    {
        return $this->hasMany(UserExam::class);
    }
}
