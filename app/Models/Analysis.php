<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;
    protected $table='analysis';
    protected $primaryKey = 'id_analysis';
    public $timestamps=false;
    protected $fillable = [
        'id_analysis',
        'municipio',
        'productor',
        'ciclo',
        'adjunto'
    ];
}
