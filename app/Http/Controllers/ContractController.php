<?php

namespace App\Http\Controllers;

use App\Models\Modem;
use App\Models\MovistarDeco;
use App\Models\ModemType;
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

    public function add(Request $request): JsonResponse
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

    public function edit(Request $request): JsonResponse 
    {
        $dateOrder = Carbon::parse($request->DateOrder);
        $dateInstall = Carbon::parse($request->DateInstall);
        $dateInactivity = Carbon::parse($request->DateInactivity);
        
        $contract = Contract::find($request->contractId);
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
        $contract->update();

        return response()->json(['status'=>'success', 'message'=>'El contrato fue actualizado']);    
    }

    public function remove(Request $request)
    {
        Contract::find($request->contractId)->delete();      
        return response()->json(['status'=>'success']);
    }

    public function list(Request $request): JsonResponse
    {
        $contracts = Contract::select('contract.id', DB::raw("DATE_FORMAT(contract.DateOrder, '%d-%m-%Y') as DateOrder"), DB::raw("DATE_FORMAT(contract.DateInstall, '%d-%m-%Y') as DateInstall"), DB::raw("DATE_FORMAT(contract.DateInactivity, '%d-%m-%Y') as DateInactivity"), 'contract.CodeOrder', 'contract.CodeInstall', 'contract.CodeInactivity', 'contract.PaymentCycle', 'contract.PaymentAmount', 'contract.serviceProviderId', 'contract.clientId', 'serviceprovider.name as service', 'provider.name as provider', 'serviceprovider.providerId')
            ->join('serviceprovider','serviceprovider.id','=','contract.serviceProviderId')
            ->join('provider','provider.id','=','serviceprovider.providerId') 
            ->get();

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
     * Store a newly created resource in storage.
     */
    public function detail(Request $request)
    {
        $modemTypes = ModemType::all();
        $contract = Contract::select('contract.id', DB::raw("DATE_FORMAT(contract.DateInstall, '%d-%m-%Y') as DateInstall"),'contract.CodeInstall', 'contract.PaymentCycle', 'contract.PaymentAmount', 'contract.clientId', 'contract.serviceProviderId', 'serviceprovider.name as service', 'provider.name as provider', 'serviceprovider.InternetService', 'serviceprovider.CableService', DB::raw("CONCAT(client.name, ' ', client.lastName) as ClientName"))
            ->join('serviceprovider','serviceprovider.id','=','contract.serviceProviderId')
            ->join('provider','provider.id','=','serviceprovider.providerId')
            ->join('client','client.id','=','contract.clientId') 
            ->where('contract.id', $request->contractId)
            ->first();

        return view('contract.detail', ['contract' => $contract, 'modemTypes' => $modemTypes]);    
    }

    public function addmodem(Request $request): JsonResponse
    {
        $row = Modem::where('MAC', $request->MAC)->get();
        if($row->count() == 0) {
            $modem = new Modem();
            $modem->MarkCode = $request->MarkCode;
            $modem->MAC = $request->MAC;
            $modem->DefaultUrl = $request->DefaultUrl;
            $modem->DefaultWifiName = $request->DefaultWifiName;
            $modem->DefaultWifiPassword = $request->DefaultWifiPassword;
            $modem->ConnectionType = $request->ConnectionType;
            $modem->State = 1;
            $modem->modemTypeId = $request->modemTypeId;
            $modem->serviceProviderId = $request->serviceProviderId;

            $modem->save();
            
            return response()->json(['status'=>'success', 'message'=>'Nuevo Modem agregado']);    
        }else{
            return response()->json(['status'=>'error', 'message'=>'El MAC ya existe']);    
        }
    }
    
    public function listmodem(Request $request): JsonResponse
    {
        $modems = Modem::select('modem.id', 'modem.MarkCode', 'modem.MAC',)
            ->where('modem.serviceProviderId', $request->serviceProviderId)
            ->get();

        return response()->json(['modems' => $modems]);
    }

    public function removemodem(Request $request)
    {
        Modem::find($request->modemId)->delete();      
        return response()->json(['status'=>'success']);
    }

    public function addmovistarDeco(Request $request): JsonResponse
    {
        $row = MovistarDeco::where('CASID', $request->CASID)->get();
        if($row->count() == 0) {
            $movistarDeco = new MovistarDeco();
            
            $movistarDeco->CASID = $request->CASID;
            $movistarDeco->CardNumber = $request->CardNumber;
            $movistarDeco->MarkCode = $request->MarkCode;
            $movistarDeco->State = 1;
            $movistarDeco->DecoType = $request->DecoType;
            $movistarDeco->serviceProviderId = $request->serviceProviderId;

            $movistarDeco->save();
            
            return response()->json(['status'=>'success', 'message'=>'Nuevo MovistarDeco agregado']);    
        }else{
            return response()->json(['status'=>'error', 'message'=>'El CASID ya existe']);    
        }
    }
    
    public function listmovistarDeco(Request $request): JsonResponse
    {
        $movistarDecos = MovistarDeco::select('movistarDeco.id', 'movistarDeco.CASID', 'movistarDeco.CardNumber',)
            ->where('movistarDeco.serviceProviderId', $request->serviceProviderId)
            ->get();

        return response()->json(['movistarDecos' => $movistarDecos]);
    }

    public function removemovistarDeco(Request $request)
    {
        MovistarDeco::find($request->movistarDecoId)->delete();      
        return response()->json(['status'=>'success']);
    }

}
