<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ServiceProvider;
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

    public function detail(Request $request): View
    {
        $provider = Provider::where('id', $request->providerId)->first();

        return view('provider.detail', ['provider' => $provider]);
    }

    public function listservice(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $services = ServiceProvider::select('serviceprovider.id', 'serviceprovider.name', 'serviceprovider.InternetService', 'serviceprovider.CableService', 'serviceprovider.description')
            ->where('serviceprovider.providerId', $request->providerId)
            ->get();

            return response()->json(['services' => $services]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function addservice(Request $request)
    {
        $internet = 0;
        if($request->InternetService) {
            $internet = 1;
        }
        $cable = 0;
        if($request->CableService) {
            $cable = 1;
        }
        $serviceProvider = new ServiceProvider();
        $serviceProvider->name = $request->name;
        $serviceProvider->InternetService = $internet;
        $serviceProvider->CableService = $cable;
        $serviceProvider->description = $request->description;
        $serviceProvider->providerId = $request->providerId;
        $serviceProvider->save();
    
        return response()->json(['status'=>'success', 'message'=>'El servicio fue agregado']);    
    }
    
    public function editservice(Request $request): JsonResponse 
    {
        $internet = 0;
        if($request->InternetService) {
            $internet = 1;
        }
        $cable = 0;
        if($request->CableService) {
            $cable = 1;
        }
        ServiceProvider::where('id', $request->serviceProviderId)
            ->update(['name' => $request->name, 'InternetService' => $internet, 'CableService' => $cable, 'description' => $request->description]);
    
        return response()->json(['status'=>'success', 'message'=>'El Servicio fue actualizado']);
    }
    
    public function removeservice(Request $request): JsonResponse
    {
        ServiceProvider::find($request->serviceProviderId)->delete();      
    
        return response()->json(['status'=>'success']);
    }
}
