<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    //relacion de 1:N con usuario
    public function usuarios(){
        return $this->hasMany(Usuario::class);
    }
}
