<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request) {
        $data = $request->only('name', 'cpf_cnpj', 'type', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'cpf_cnpj' => ['required', 'unique:users'],
            'type' => ['required', Rule::in(['L', 'U'])],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed']
        ]);

        if ($validator->fails()) {
            return response($validator->messages(), 400);
        }

        $user = new User;
        $user->name = $data['name'];
        $user->cpf_cnpj = $data['cpf_cnpj'];
        $user->type = $data['type'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return response('Salvo com sucesso!', 200);
    }
}
