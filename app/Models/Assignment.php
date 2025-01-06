<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'class_id',
        'due_date',
        'attachment_path',
        'max_score',
        'created_at',
        'scheduled_at',
        'status',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
