<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_title',
        'project_description',
        'project_image',
        'user_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}