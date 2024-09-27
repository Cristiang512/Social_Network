<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;
    protected $table='idea';
    public $timestamps=false;
    protected $fillable = [
        'id_idea',
        'text',
        'imageField',
        'video_link',
        'id_group',
        'id_user'
    ];
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_idea');
    }
}
