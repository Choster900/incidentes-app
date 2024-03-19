<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    //relacion entre los modelos
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    } 

    public function rol(){
        return $this->belongsTo(Rol::class);
    }    
    
    //relacion de 1:N con incidente
    public function incidentes(){
        return $this->hasMany(Incidente::class);
    }
        
}
