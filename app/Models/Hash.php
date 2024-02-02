<?php

namespace App\Models;

use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hash extends Model
{
    protected $fillable = [
        'id',
    ];

    protected $appends = ['code'];

    public function getCodeAttribute()
    {
        
        if (isset($this->attributes['id'])) {
            return Hashids::encode($this->attributes['id']);
        }
    }
}
