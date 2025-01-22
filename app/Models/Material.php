<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'material';
    protected $primaryKey = 'id';
    protected $fillable = [
        'class_id',
        'teacher_id',
        'title',
        'description',
        'attachment_path',
        'link_url',
        'scheduled_at',
        'status',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}
