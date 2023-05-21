<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Casos extends Model
{
    use HasFactory;

    protected $table="casos";

    public function fiscal(){
        return $this->belongsTo(Fiscal::class);
    }

    public function juzgado(){
        return $this->hasOne(Juzgado::class);
    }
}
