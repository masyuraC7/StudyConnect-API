<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $table = 'submission';
    protected $primaryKey = 'id';
    protected $fillable = [
        'assignment_id',
        'student_id',
        'submitted_at',
        'file_path',
        'grade',
        'status',
        'feedback',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
