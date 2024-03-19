<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    //relacion de 1:N con roles_permisos
    public function rolesPermisos(){
        return $this->hasMany(RolPermiso::class);
    }    
}
