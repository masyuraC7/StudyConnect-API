<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCalendar extends Model
{
    use HasFactory;
    protected $table = 'class_calendar';
    protected $primaryKey = 'id';
    protected $fillable = [
        'class_id',
        'event_name',
        'event_date',
        'description',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
