<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Profiler extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "status",
        "number",
        "model",
        "ip",
        "year_model",
        "machine_speed",
    ];

    public function insertions()
    {
        return $this->hasMany(Insertion::class, "machine_number", "number");
    }
}
