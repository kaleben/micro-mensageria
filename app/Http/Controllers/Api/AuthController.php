<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sistema;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function cadastro(Request $request) {
        //Cria token com privilégios de administrador
        if(isset($request->admin_token)){
            if($request->admin_token === config('auth.admin_token')){
                $sistema = $this->setSistema($request->nome_sistema);
                $token = $sistema->createToken($request->token_name, ['admin:admin']);
            } else {
                return response()->json(['erro' => 'admin_token inválido']);
            }
        } else {
            $sistema = $this->setSistema($request->nome_sistema);
            $token = $sistema->createToken($request->token_name);
        }

        return ['token' => $token->plainTextToken];
    }

    public function setSistema($nome_sistema){
        $sistema = new Sistema();

        $sistema->txNome = $nome_sistema;
        $sistema->save();

        return $sistema;
    }

    public function getAuthSistema(Request $request) {
        return $request->user();
    }

    // Deleta token do sistema logado
    public function deleteToken(Request $request, $tokenId = null){
        if($tokenId === null) {
            $request->user()->currentAccessToken()->delete();
        } else {
            $request->user()->tokens()->where('id', $tokenId)->delete();
        }

        return response()->json(["message" => "Token apagado"]);
    }

}
