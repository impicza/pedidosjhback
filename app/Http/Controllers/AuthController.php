<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->dias_despacho = implode(',', $request->dias_despacho);
        $user->activo = 1;
        $user->password =  Hash::make($request->password);
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    public function changePassword(Request $request)
    {
        $user = User::where('email','=', $request->email)->get();
        $user = $user[0];

        $val = false;

        if (Hash::check($request->old_pass, $user->password)) {
            $user->password = Hash::make($request->new_pass);
            $val = $user->save();
        } else {
            return 'Error: La contraseña anterior es incorrecta.';
        }

        if ($val) {
            return 'done';
        } else {
            return 'Error: no se pudo modificar la contraseña.';
        }
        
    }

    public function login(Request $request)
    {
        $user = User::where('email','=', $request->email)->get();

        if ($user[0]->activo == 1) {
            $credentials = $request->only('email', 'password');
            if ($token = $this->guard()->attempt($credentials)) {
                return response()->json(['status' => 'success','data' => ['token' => $token]], 200)->header('Authorization', $token);
            }
            return response()->json(['error' => 'login_error'], 401);
        } else {
            return 'Error: Usuario Inactivo, Contacte con el Proveedor.';
        }
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success','data' => ['token' => $token]], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
