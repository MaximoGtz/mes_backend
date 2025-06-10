<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    protected $fillable = [
        "worker",
        "machine_number",
        "justification",
        "date_justified",
        "minutes_off"
    ];
    public function profiler(){
        $this->belongsTo(Profiler::class);
    }
}
