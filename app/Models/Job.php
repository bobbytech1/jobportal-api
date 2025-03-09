<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'company_name',
        'salary_range',
        'location',
        'status',
        'user_id', // Add this if you want to allow mass assignment for the user who created the job
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function applications()
{
    return $this->hasMany(Application::class, 'job_id');
}
}
