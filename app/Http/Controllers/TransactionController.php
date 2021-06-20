<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Helpers\Mock;

use App\Models\Transaction;
use App\Models\User;

class TransactionController extends Controller
{
    private $mock;

    public function __construct(Mock $mock) {
        $this->mock = $mock;
    }

    public function store(Request $request) {
        $data = $request->only('payee', 'value');

        $validator = Validator::make($data, [
            'payee' => ['required', 'numeric'],
            'value' => ['required', 'numeric', 'min:0.01']
        ]);

        if ($validator->fails()) {
            return response($validator->messages(), 400);
        }

        $loggedUser = JWTAuth::user();
        if ($loggedUser->type=='L') {
            return response()->json(['message' => "Usuário do tipo 'Lojista' não pode enviar dinheiro, apenas receber!"], 400);
        } else {
            $payer = User::find($loggedUser->id);
            $payee = User::find($data['payee']);
            if ($payee) {
                $transaction = new Transaction;
                $transaction->payer = $loggedUser->id;
                $transaction->payee = $payee->id;
                $transaction->value = $data['value'];
                $transaction->dt_transaction = date('Y-m-d H:i:s');

                if ((float) $payer->balance >= (float) $data['value']) {
                    $authorization = $this->mock->authorization();

                    if ($authorization) {
                        $transaction->save();

                        $payer->balance = (float) $payer->balance - (float) $data['value'];
                        $payer->save();

                        $payee->balance = (float) $payee->balance + (float) $data['value'];
                        $payee->save();
                    } else {
                        return response()->json(['message' => "Unauthorized Service!"], 401);
                    }
                } else {
                    return response()->json(['message' => "Saldo insuficiente!"], 500);
                }
            } else {
                return response()->json(['message' => "Usuário não encontrado!"], 500);
            }
        }
    }
}
