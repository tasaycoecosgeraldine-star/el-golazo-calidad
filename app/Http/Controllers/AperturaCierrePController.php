<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use App\Http\Requests\AperturaCierreFormRequest;
use App\Models\AperturaCierre;

class AperturaCierrePController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {


        $registro = DB::table('caja')->where('codLocalidad', auth()->user()->codLocalidad)->where('montoCierre', '=', null)->first();

            // $caja = DB::table('caja')->where('codCaja', $query)->first();
        return view('caja.apertura_cierre_p.index', ["registro"=>$registro]);

    }
}
