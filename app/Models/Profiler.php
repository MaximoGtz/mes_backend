<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Profiler extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "name",
        "status",
        "number",
        "model",
        "ip",
        "year_model",
        "machine_speed",
    ];
    protected $hidden = [
        "deleted_at"
    ];
    public function insertions()
    {
        return $this->hasMany(Insertion::class, "machine_number", "number");
    }
    protected static function booted()
    {
        static::created(function ($profiler) {
            $profiler->name = 'China' . $profiler->id;
            $profiler->save();
        });
    }
}
