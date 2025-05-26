<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Esto es para añadir las configuraciones de soft deletes a tu modelo, checa las migraciones para agregar el dato y poder trabajarlo
use Illuminate\Database\Eloquent\SoftDeletes;
class Insertion extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "recipe_number",
        "profile_length",
        "distance_between_holes",
        "length_before_reset",
        "machine_number",
        "good_piece",
        "cicle_time"
    ];
    protected $hidden = [
        "updated_at",
        "deleted_at"
    ];
    public function profiler()
    {
        return $this->belongsTo(Profiler::class);
    }
}
