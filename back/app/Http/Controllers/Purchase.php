<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Deposit as Deposits;
use App\Models\Purchase as Purchases;

class Purchase extends Controller
{
    public function makePurchase(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'userId' => 'required',
            'value' => 'required',
            'description' => 'required'
        ]);

        $checkDeposit = Deposits::where('user_id', $request['userId'])
            ->where('current_deposit', ">=", $request['value'])
            ->where('status', 1)
            ->get();

        if ($checkDeposit != []) {
            $deposit = Deposits::find($checkDeposit[0]['id']);
            $deposit->current_deposit -= $request['value'];
            $deposit->save();

            $purchase = new Purchases();
            $purchase->user_id = $request['userId'];
            $purchase->value = $request['value'];
            $purchase->description = $request['description'];
            $purchase->save();

            return response()->json($purchase->id);
        }

        return response()->json("Unable to make this purchase at this moment");
    }
}
