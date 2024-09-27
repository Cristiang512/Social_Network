<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $table='information';
    public $timestamps=false;
    protected $fillable = [
        'id_information',
        'text',
        'imageField',
        'video_link',
        'date',
        'id_user'
    ];
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_information');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_information');
    }

}
