<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table = 'group_user'; // Nombre de la tabla pivot

    // Asegúrate de configurar correctamente las llaves foráneas
    protected $primaryKey = ['group_id', 'user_id'];
    public $incrementing = false;

    // Definir las relaciones y otros métodos si es necesario
}
