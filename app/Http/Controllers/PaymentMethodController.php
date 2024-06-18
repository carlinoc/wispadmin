<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('paymentmethod.index');
    }

    public function list(Request $request): JsonResponse
    {
        $paymentMethods = PaymentMethod::all();

        return response()->json(['paymentMethods' => $paymentMethods]);
    }

    public function add(Request $request): JsonResponse
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->name = $request->name;
        $paymentMethod->description = $request->description;
        $paymentMethod->save();

        return response()->json(['status'=>'success', 'message'=>'El método de pago fue agregado']);    
    }

    public function edit(Request $request): JsonResponse 
    {
        $paymentMethod = PaymentMethod::find($request->paymentMethodId);
        $paymentMethod->name = $request->name;
        $paymentMethod->description = $request->description;
        $paymentMethod->update();

        return response()->json(['status'=>'success', 'message'=>'El método de pago fue actualizado']);    
    }

    public function remove(Request $request)
    {
        PaymentMethod::find($request->paymentMethodId)->delete();      
        return response()->json(['status'=>'success']);
    }
}
