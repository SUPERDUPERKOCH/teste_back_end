<?php

namespace App\Http\Controllers;

use App\Models\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class HashController extends Controller
{
    public function hashids(Hash $redirect){
        

        $code = $redirect->code;

        return view('welcome', compact('redirect'));

    }


}

