<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentario'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'id_publication',
        'id_idea',
        'id_idea_forum',
        'id_information',
        'user_id', // El ID del usuario que realizó el comentario
        'text',
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'id_publication');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
