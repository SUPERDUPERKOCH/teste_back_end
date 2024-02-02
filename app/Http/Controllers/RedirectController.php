<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Hash;
use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class RedirectController extends Controller
{
    
    public function redirect($redirect_id) 
    { 
        $redirect_model = new Redirect();
        $id = $redirect_model->decode($redirect_id);
        
        if(!count($id)){

            return redirect('/');
        
        }

        $redirect = Redirect::find($id[0]);

    
        if(!$redirect){

            return redirect('/');
    
        }

        return redirect('http://' . $redirect->url_destino);
    
   }

    public function show(Redirect $redirect) 
    { 
        $redirects = Redirect::where('status', 1)->get();

        return $redirects;
    }

    public function add()
    { 
       return view('redirect.add');
    }

    public function create(Request $request)
    { 
        $redirect= Redirect::create([
            'status' => $request->input('status'),
            'ultimo_acesso' => $request->input('ultimo_acesso'),
            'url_destino' => $request->input('url_destino'),
        ]);
    
        return response()->json(200);
    }

    public function edit($encoded_id) 
    { 
        $redirect = Redirect::find($encoded_id);
    
        return view('redirect.edit', compact('redirect'));
    }

   public function update(Request $request, $encoded_id)
    { 
        $redirect_model = new Redirect();
        $id = $redirect_model->decode($encoded_id);

          $redirect = Redirect::where('id', $id)->update([
               'status' => $request->input('status'),
               'ultimo_acesso' => $request->input('ultimo_acesso'),
               'url_destino' => $request->input('url_destino'),
           ]);

        return response()->json(200);
    }

    public function delete(Request $request, $encoded_id)
    { 
        $redirect_model = new Redirect();
        $id = $redirect_model->decode($encoded_id);

        $redirect = Redirect::destroy($id);

        return response()->json(200);
    }

    public function stats($encoded_id)
    {
        //Total acessos
        $quantidade_acesso = RedirectLog::where('header_referer', env('APP_URL') . '/' . 'r/' . $encoded_id)->count();

        //Pegar ip
        $quantidade_ip = RedirectLog::where('header_referer', env('APP_URL') . '/' . 'r/' . $encoded_id)->select('ip_request')->distinct()->count('ip_request');

        //Top Referrers
        $top_referers = RedirectLog::select('header_referer')
        ->groupBy('header_referer')
        ->orderByRaw('COUNT(*) DESC')
        ->value('header_referer');

        //Contagem dos últimos 10 dias
        $dez_ultimos_acessos = RedirectLog::where('header_referer', env('APP_URL') . '/' . 'r/' . $encoded_id)
        ->whereBetween('data_hora_acesso', [Carbon::now()->subDay(10), Carbon::now()])
        ->count();

        $dez_ultimos_ips = RedirectLog::where('header_referer', env('APP_URL') . '/' . 'r/' . $encoded_id)
        ->whereBetween('data_hora_acesso', [Carbon::now()->subDay(10), Carbon::now()])
        ->select('ip_request')
        ->distinct()
        ->count('ip_request');


        return response()->json(['quantidade_acesso' => $quantidade_acesso, 'quantidade_ip' => $quantidade_ip, 'top_referers' => $top_referers, 'Últimos dez dias' => ['date' =>Carbon::now()->subDay(10), 'dez_ultimos_acessos' => $dez_ultimos_acessos, 'dez_ultimos_ips' => $dez_ultimos_ips]]);
    }
}
