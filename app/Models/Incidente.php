<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    use HasFactory;
    //relacion de 1:N con usuario
    public function usuario(){
        return $this->belongsTo(Usuario::class);
    } 
    
    //relacion de 1:N con imagen
    public function imagenes(){
        return $this->hasMany(Imagen::class);
    }
    
    //relacion de 1:N con seguimiento
    public function seguimientos(){
        return $this->hasMany(Seguimiento::class);
    }     
}
