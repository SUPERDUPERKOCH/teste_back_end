<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectLog extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    protected $table      = 'redirect_logs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ip_request',
        'user_request',
        'header_referer',
        'query_params',
        'data_hora_acesso',

    ];
}
