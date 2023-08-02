<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'days',
        'clock',
        'grade_id'
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
