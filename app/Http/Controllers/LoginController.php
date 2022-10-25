<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCurso;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Auth::shouldUse('webCurso');
        // if($usuario!=null){
        //     if(md5($request->password) == $usuario->password){
        //         // dd($guard);
        //         try {
        //             //auth()->guard('webCurso')->login($usuario);
        //             Auth::login($usuario);
        //             // Auth::login($usuario);
        //             $request->session()->regenerate();
        //             return redirect()->intended(route('user_information'));
        //         } catch (\Throwable $th) {
        //             dd($th);
        //         }

        //     }
        // }
        /*Este metodo lo podemos utilizar tambien de la misma forma que la de arriba*/
        // if(Auth::attempt($data,$remember)){
        //     $request->session()->regenerate();
        //     return redirect()->intended(route('user_information'));
        // }

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

}
