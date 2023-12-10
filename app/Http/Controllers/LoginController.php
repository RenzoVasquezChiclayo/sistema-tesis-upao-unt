<?php

namespace App\Http\Controllers;

use App\Mail\RecuperarContraseñaMail;
use App\Models\User;
use App\Models\UserCurso;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function index(){
        return view('login.login');
    }

    public function validateLogin(Request $request){


        $remember = $request->filled('rememberme');
        $data = $request->validate([
            'name'=>'required',
            'password'=>'required'
        ],[
            'name.required' => 'Ingrese su Usuario',
            'password.required' => 'Ingrese su Contraseña'
        ]);

        $usuario = User::where('name','=',$request->name)->first();
        if($usuario!=null){
            if(md5($request->password) == $usuario->password){
                try {
                    Auth::login($usuario);
                    $request->session()->regenerate();
                    return redirect()->intended(route('user_information'));
                } catch (\Throwable $th) {
                    dd($th);
                }
            }
        }

        throw ValidationException::withMessages([
            'message'=>'El usuario o la contraseña es incorrecto.'
            //'message'=>__('auth.failed')
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('indexlogin');
    }

    public function enviarCorreoParaCambio(Request $request){
        try {
            $name_usuario = "";
            $correo = $request->correo_reset;
            if ($correo != null) {
                $find_estudiante = DB::table('estudiante_ct2022 as es')->where('es.correo',$correo)->first();
                if ($find_estudiante != null) {
                    $nombres = $find_estudiante->nombres.' '.$find_estudiante->apellidos;
                    $name_usuario = $find_estudiante->cod_matricula.'-C';
                    $url = action([LoginController::class,'verRecuperarContraseña'],['codigo' => $find_estudiante->cod_matricula, 'nombres' => $nombres,'name_usuario'=>$name_usuario]);
                    Mail::to($correo)->send(new RecuperarContraseñaMail($nombres,$url));
                }else{
                    $find_asesor = DB::table('asesor_curso as as')->where('as.correo',$correo)->first();
                    if ($find_asesor != null) {
                        $nombres = $find_asesor->nombres.' '.$find_asesor->apellidos;
                        $name_usuario = $find_asesor->username;
                        $url = action([LoginController::class,'verRecuperarContraseña'],['codigo' => $find_asesor->cod_docente, 'nombres' => $nombres,'name_usuario'=>$name_usuario]);
                        Mail::to($correo)->send(new RecuperarContraseñaMail($nombres,$url));
                    }else{
                        return redirect()->route('indexlogin')->with('datos','oknotregister');
                    }
                }

            }
            return redirect()->route('indexlogin')->with('datos','ok');
        } catch (\Throwable $th) {
            return redirect()->route('indexlogin')->with('datos','oknot');
        }

    }

    public function verRecuperarContraseña(Request $request){
        $name_usuario = $request->input('name_usuario');
        $codigo = $request->input('codigo');
        $nombres = $request->input('nombres');
        return view('login.recuperar_contraseña',['codigo'=>$codigo,'nombres'=>$nombres,'name_usuario'=>$name_usuario]);
    }

    public function guardarResetContraseña(Request $request){
        try {
            $name_usuario = $request->name_usuario;
            $usuario = User::where('name', '=', $name_usuario)->first();
            if ($usuario != null) {
                $usuario->password = md5($request->nueva_contraseña);
                $usuario->save();
                Auth::login($usuario);
                $request->session()->regenerate();
                return redirect()->intended(route('user_information'))->with('datos','okresetcontra');
            }
        } catch (\Throwable $th) {
            return redirect()->route('recuperar_contra')->with('datos','oknotresetcontra');
        }
    }

}
