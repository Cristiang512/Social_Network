<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_like';

    protected $fillable = [
        'id_user',
        'id_publication',
        'id_group',
        'id_idea',
        'id_idea_forum',
        'id_information',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'id_publication');
    }
    public function idea()
    {
        return $this->belongsTo(Idea::class, 'id_idea');
    }
    public function ideaForum()
    {
        return $this->belongsTo(IdeaForum::class, 'id_idea_forum');
    }
    public function information()
    {
        return $this->belongsTo(Information::class, 'id_information');
    }

}

