<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiscal extends Model
{
    use HasFactory;

    protected $table = 'fiscals';

    public function casos(){
        return $this->hasMany(Caso::class);
    }

}
