<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaForum extends Model
{
    use HasFactory;
    protected $table='idea_forum';
    public $timestamps=false;
    protected $fillable = [
        'id_idea_forum',
        'text',
        'date',
        'id_forum',
        'id_user'
    ];
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_idea_forum');
    }
}
