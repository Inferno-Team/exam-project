<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table = "courses";
    protected $fillable = [
        'id',
        'name',
        'type',
        'section_id',
        'year_id',
        'created_at',
        'updated_at',
    ];
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
}
