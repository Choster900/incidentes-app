<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = "roles";
    //relacion 1:N con usuario
    public function usuarios(){
        return $this->hasMany(Usuario::class);
    }
    //relacion de 1:N con roles_permisos
    public function rolesPermisos(){
        return $this->hasMany(RolPermiso::class);
    }    
}
