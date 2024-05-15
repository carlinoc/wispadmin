<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $zones = Zone::all();

        return view('provider.index', ['zones' => $zones]);
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $providers = Provider::select('provider.id', 'provider.name', 'provider.phone', 'provider.contactName', 'provider.contactPhone', 'provider.description', 'provider.zoneId', 'zone.nickName as zoneName')
            ->join('zone','zone.id', '=', 'provider.zoneId')
            ->get();

            return response()->json(['providers' => $providers]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request): JsonResponse 
    {
        $provider = new Provider();
        $provider->name = $request->name;
        $provider->phone = $request->phone;
        $provider->contactName = $request->contactName;
        $provider->contactPhone = $request->contactPhone;
        $provider->description = $request->description;
        $provider->zoneId = $request->zoneId;
        $provider->save();

        return response()->json(['status'=>'success', 'message'=>'El proveedor fue agregado']);    
    }

    public function edit(Request $request): JsonResponse 
    {
        Provider::where('id', $request->providerId)
            ->update(['name' => $request->name, 'phone' => $request->phone, 'contactName' => $request->contactName, 'contactPhone' => $request->contactPhone, 'description' => $request->description, 'zoneId' => $request->zoneId,]);

        return response()->json(['status'=>'success', 'message'=>'El proveedor fue actualizado']);
    }

    public function remove(Request $request): JsonResponse
    {
        Provider::find($request->providerId)->delete();      

        return response()->json(['status'=>'success']);
    }
}
