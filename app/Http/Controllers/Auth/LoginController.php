<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use Hash;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $remember = $request->filled('remember');
        // if(Auth::attempt($credentials, $remember)){
        if(Auth::guard('web')->attempt($credentials, $remember)){
            $request->session()->regenerate();
            if (auth()->user()->estado == 'ACTIVO') {
                // if (auth()->user()->tipo =="ADMINISTRADOR"){
                return redirect()->intended('registro/registro');
                // }else{
                //     $localidad = DB::table('localidad')->where('codLocalidad', auth()->user()->codLocalidad)->first();
                //     return Redirect::to('registro/registro?searchText=' . $localidad->codLocalidad . '_' . $localidad->nomLocalidad);
                // }
            }else{
                Auth::logout();
                return redirect('/')->with('flash','Su cuenta se encuentra INACTIVA, por favor COMUNIQUESE con el ADMINISTRADOR!');
            }
        }
        // if (Auth::guard('web')->attempt($credentials, $remember)) {
        //     return redirect()->intended(route('home'));
        // }

        if (Auth::guard('client')->attempt($credentials, $remember)) {
            if (auth()->guard('client')->user()->estado == 'ACTIVO') {
                return redirect()->intended('registroCliente/registro');
            }
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed')
        ]);
    }





    public function logout(Request $request){

        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function redirectTo()
    {
        switch (auth()->user()->role) {
            case 'foo':
                return route('foo.home');

            case 'bar':
                return route('bar.home');

            default:
                auth()->logout();
                return route('web.welcome');
        }
    }
}
