<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_forum';
    protected $table='forum';
    public $timestamps=false;
    protected $fillable = [
        'id_forum',
        'descripcion',
        'opening_date',
        'closing_date',
        'id_user'
    ];
}
