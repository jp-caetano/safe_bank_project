<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function deposit(Request $request): \Illuminate\Http\JsonResponse
    {
        $valueToDeposit = $request->input('deposit_value');

        $user = Auth::user();

        $newValue = $user->balance + $valueToDeposit;

        DB::table('users')
            ->where('id', $user->id)
            ->update(['balance' => $newValue]);

        $transaction = new Transaction([
            'type' => 'deposit',
            'description' => 'Depósito realizado',
            'amount' => $valueToDeposit,
        ]);

        $user->transactions()->save($transaction);

        return response()->json(['message' => 'Depósito realizado com sucesso']);
    }

    public function withdraw(Request $request): \Illuminate\Http\JsonResponse
    {
        $valueToWithdraw = $request->input('withdraw_value');

        $user = Auth::user();

        $newValue = $user->balance - $valueToWithdraw;

        DB::table('users')
            ->where('id', $user->id)
            ->update(['balance' => $newValue]);

        $transaction = new Transaction([
            'type' => 'withdraw',
            'description' => 'Saque realizado',
            'amount' => -$valueToWithdraw,
        ]);

        $user->transactions()->save($transaction);

        return response()->json(['message' => 'Saque realizado com sucesso']);
    }

    public function transfer(Request $request): \Illuminate\Http\JsonResponse
    {
        $valueToTransfer = $request->input('transfer_value');

        $user = Auth::user();
        $destinationUser = User::where('id', $request->transfer_id)->first();

        $newValue = $user->balance - $valueToTransfer;
        $newDestinationValue = $destinationUser->balance + $valueToTransfer;

        DB::table('users')
            ->where('id', $user->id)
            ->update(['balance' => $newValue]);

        $transaction = new Transaction([
            'type' => 'transfer',
            'description' => "Transferência enviada para $destinationUser->name",
            'amount' => -$valueToTransfer,
        ]);

        $user->transactions()->save($transaction);

        DB::table('users')
            ->where('id', $destinationUser->id)
            ->update(['balance' => $newDestinationValue]);

        $transaction = new Transaction([
            'type' => 'transfer',
            'description' => "Transferência recebida de $user->name",
            'amount' => $valueToTransfer,
        ]);

        $destinationUser->transactions()->save($transaction);

        return response()->json(['message' => 'Transferência realizada com sucesso']);
    }

    public function transactions(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)->get();

        return response()->json($transactions);
    }
}
