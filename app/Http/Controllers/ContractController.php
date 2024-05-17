<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Provider;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::all();
        $clients = Client::all();

        return view('contract.index', ['providers' => $providers, 'clients' => $clients]);
    }

    public function add(Request $request)
    {
        $dateOrder = Carbon::parse($request->DateOrder);
        $dateInstall = Carbon::parse($request->DateInstall);
        $dateInactivity = Carbon::parse($request->DateInactivity);

        $contract = new Contract();
        $contract->serviceProviderId = $request->serviceProviderId;
        $contract->DateOrder = $dateOrder;
        $contract->CodeOrder = $request->CodeOrder;
        $contract->DateInstall = $dateInstall;
        $contract->CodeInstall = $request->CodeInstall;
        $contract->DateInactivity = $dateInactivity;
        $contract->CodeInactivity = $request->CodeInactivity;
        $contract->PaymentCycle = $request->PaymentCycle;
        $contract->PaymentAmount = $request->PaymentAmount;
        $contract->clientId = $request->clientId;
        $contract->save();

        return response()->json(['status'=>'success', 'message'=>'El contrato fue agregado']);    
    }

    public function list(Request $request): JsonResponse
    {
        $contracts = Contract::all();

        return response()->json(['contracts' => $contracts]);
    }

    public function listservice(Request $request): JsonResponse
    {
        $services = ServiceProvider::select()
        ->where('serviceprovider.providerId', $request->providerId)
        ->get();

        return response()->json(['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        //
    }
}
