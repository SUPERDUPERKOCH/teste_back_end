<?php

namespace App\Models;


use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Redirect extends Model
{
    use HasFactory;

    use SoftDeletes;
    public $timestamps = true;
    protected $table      = 'redirects';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'status',
        'ultimo_acesso',
        'url_destino',

    ];

    protected $appends = ['code'];

    public function getIdAttribute()
    {
        
        if (isset($this->attributes['id'])) {
            return Hashids::encode($this->attributes['id']);
        }
    }

    public function getCodeAttribute()
    {
        
        if (isset($this->attributes['id'])) {
            return Hashids::encode($this->attributes['id']);
        }
    }

    public function decode($id)
    {
        
        return Hashids::decode($id);
        
    }
}
