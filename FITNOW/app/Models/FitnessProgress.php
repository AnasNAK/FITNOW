<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessProgress extends Model
{
    use HasFactory;
    protected $table ='fitness_progresses';

    protected $fillable = [
        'user_id',
        'weight',
        'measurements',
        'performance_data',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
