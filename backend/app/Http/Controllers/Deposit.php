<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Deposit as Deposits;
use function PHPUnit\Framework\isEmpty;

class Deposit extends Controller
{
    public function makeDeposit(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'userId' => 'required',
            'value' => 'required'
        ]);

        $deposits = Deposits::updateOrCreate(
            ['user_id' => $request['userId']],
            [
                'transit_deposit' => $request['value'],
                'status' => false
            ]
        );

        return response()->json($deposits->id);
    }

    public function checkUserBalance(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "userId" => "required",
            "value" => "required"
        ]);


        return response()->json(Deposits::where('user_id', $request['userId'])
            ->where('transit_deposit', ">=", $request['value'])
            ->orWhere('current_deposit', ">=", $request['value'])
            ->get());
    }

    public function listUserBalance(Request $request): JsonResponse
    {
        $validate = $request->validate([
            "userId" => "required"
        ]);

        $deposit = Deposits::where('user_id', $request['userId'])->get();

        if (!$deposit) {
            return response()->json('User Balance not found', 400);
        }

        return response()->json($deposit);
    }

    public function listPendingDeposit(): JsonResponse
    {
        return response()->json(Deposits::where('status', false)->get());
    }

    public function evaluateDeposit(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'depositId' => 'required',
            'evaluation' => 'required'
        ]);

        if (!$validate) {
            return response()->json('Evaluation not given', 400);
        }

        $deposit = Deposits::find($request['depositId']);

        if (!$deposit) {
            return response()->json('Deposit not found', 400);
        }

        if ($request['evaluation'] == 1) {
            $deposit->current_deposit += $deposit->transit_deposit;
            $deposit->transit_deposit = 0;
            $deposit->status = true;
            $deposit->save();
        }

        return response()->json("Deposit approved");
    }
}
