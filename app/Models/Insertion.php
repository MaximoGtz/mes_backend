<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Insertion extends Model
{
    use HasFactory;
    protected $fillable = [
        "recipe_number",
        "profile_length",
        "distance_between_holes",
        "length_before_reset",
        "machine_number"
    ];
    public function profiler()
    {
        return $this->belongsTo(Profiler::class);
    }
}
