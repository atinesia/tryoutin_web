<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    // Izinkan semua kolom diisi secara mass-assignment
    protected $guarded = ['id'];

    public function userExam()
    {
        return $this->belongsTo(UserExam::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
