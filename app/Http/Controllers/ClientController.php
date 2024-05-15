<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Plan;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $zones = Zone::all();

        return view('client.index', ['zones' => $zones]);
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $clients = Client::select('client.id', 'client.name', 'client.phone', 'client.lastName', 'client.DNI', 'client.adress', 'client.email', 'client.zoneId', 'zone.nickName as zoneName')
            ->join('zone','zone.id', '=', 'client.zoneId')
            ->get();

            return response()->json(['clients' => $clients]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request): JsonResponse 
    {
        $rows = DB::table('client')->where('DNI', $request->DNI)->count();
        if($rows > 0 ) {
            return response()->json(['status'=>'error', 'message'=>'Ya existe un cliente con el mismo DNI']);    
        }else{
            $client = new Client();
            $client->name = $request->name;
            $client->lastName = $request->lastName;
            $client->DNI = $request->DNI;
            $client->phone = $request->phone;
            $client->adress = $request->adress;
            $client->email = $request->email;
            $client->zoneId = $request->zoneId;
            $client->save();

            return response()->json(['status'=>'success', 'message'=>'El cliente fue agregado']);    
        } 
    }

    public function edit(Request $request): JsonResponse 
    {
        Client::where('id', $request->clientId)
            ->update(['name' => $request->name, 'phone' => $request->phone, 'lastName' => $request->lastName, 'phone' => $request->phone, 'DNI' => $request->DNI, 'adress' => $request->adress, 'email' => $request->email, 'zoneId' => $request->zoneId,]);

        return response()->json(['status'=>'success', 'message'=>'El cliente fue actualizado']);
    }

    public function remove(Request $request): JsonResponse
    {
        Client::find($request->clientId)->delete();      

        return response()->json(['status'=>'success']);
    }

    public function detail(Request $request): View
    {
        $client = Client::where('id', $request->clientId)->first();

        return view('client.detail', ['client' => $client]);
    }

    public function addPlan(Request $request)
    {
        $dateOrder = Carbon::parse($request->dateOrder);
        $dateInstall = Carbon::parse($request->dateInstall);
        $active = 0;
        if($request->active){
            $active = 1;
        }

        $plan = new Plan();
        $plan->dateOrder = $dateOrder;
        $plan->dateInstall = $dateInstall;
        $plan->paymentAmount = $request->paymentAmount;
        $plan->active = $active;
        $plan->planType = $request->planType;
        $plan->clientId = $request->clientId;
        $plan->save();

        return response()->json(['status'=>'success', 'message'=>'El plan fue agregado']);    
    }

    public function planList(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            $plans = Plan::select('plan.id', 'plan.dateOrder', 'plan.dateInstall', 'plan.paymentAmount', 'plan.active', 'plan.planType')
                ->join('client', 'client.id', '=', 'plan.clientId')
                ->where('plan.clientId', $request->clientId)
                ->get();
             
            return response()->json(['plans' => $plans]);
        } else {
            abort(403);
        }
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
    public function show(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
