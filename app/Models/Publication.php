<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $table='publication';
    public $timestamps=false;
    protected $fillable = [
        'id_publication',
        'text',
        'imageField',
        'video_link',
        'date',
        'id_user'
    ];
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_publication');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_publication');
    }

}
