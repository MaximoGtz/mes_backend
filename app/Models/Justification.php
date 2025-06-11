<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    protected $fillable = [
        "worker",
        "profiler_id",
        "justification",
        "date_justified",
        "minutes_off"
    ];
    protected $hidden = [
        "created_at",
        "updated_at"
    ];
    public function profiler(){
        $this->belongsTo(Profiler::class);
    }
}
