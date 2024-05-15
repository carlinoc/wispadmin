<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('zone.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $zones = Zone::all();
            return response()->json(['zones' => $zones]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request)
    {
        $zone = new Zone();
        $zone->name = $request->name;
        $zone->nickName = $request->nickName;
        $zone->district = $request->district;
        $zone->save();

        return response()->json(['status'=>'success', 'message'=>'La zona fue agregada']);    
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): JsonResponse 
    {
        Zone::where('id', $request->zoneId)
            ->update(['name' => $request->name, 'nickName' => $request->nickName, 'district' => $request->district]);

        return response()->json(['status'=>'success', 'message'=>'La zona fue actualizada']);
    }

    public function remove(Request $request): JsonResponse
    {
        Zone::find($request->zoneId)->delete();      

        return response()->json(['status'=>'success']);
    }

    public static function getDistrict($code){
        $district="";
        switch ($code) {
            case "CC":
                $district="Cusco";
                break;
        }
        return $district;
    }
}
