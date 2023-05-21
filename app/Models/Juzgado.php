<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juzgado extends Model
{
    use HasFactory;

    protected $table="juzgados";

    public function caso(){
        return $this->belongsTo(Casos::class);
    }


}
