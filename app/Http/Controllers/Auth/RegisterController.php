<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Cliente;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'favoriteColor'=>'required',
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */


    function register(Request $request){

         $request->validate([
            'numDocumento'=>'required|max:15|unique:cliente',
            'nombres' => 'required',
            'email' => 'required|email|unique:cliente',
            'telefono'=>'required|max:15|unique:cliente',
            'password' => 'required|min:6|confirmed',
         ]);

        $mytime = Carbon::now('America/Lima');
        $fecha_hora = $mytime->toDateTimeString();

         $user = new Cliente();
         $user->numDocumento = $request->numDocumento;
         $user->nombres = $request->nombres;
         $user->email = $request->email;
         $user->telefono = $request->telefono;
         $user->password = bcrypt($request->password);
         $user->estado = 'ACTIVO';
         $user->tipo = 'CLIENTE';
         $user->creacion = $fecha_hora;

         if( $user->save() ){
            return redirect()->back()->with('success','Ahora está registrado con éxito');
         }else{
             return redirect()->back()->with('error','Fallo en el registro');
         }
    }


}
