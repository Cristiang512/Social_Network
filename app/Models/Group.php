<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_group';
    protected $table='groups';
    public $timestamps=false;
    protected $fillable = [
        'id_group',
        'name',
        'descripcion',
        'icon',
        'id_user'
    ];

    public function isMember($user)
    {
        return $this->members->contains($user);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }
    public function requests()
    {
        return $this->hasMany(GroupRequest::class, 'group_id');
    }
    public function hasPendingRequest($user)
    {
        return $this->requests->contains(function ($request) use ($user) {
            return $request->user_id === $user->id;
        });
    }

}
