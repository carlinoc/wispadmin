<?php

namespace App\Http\Controllers;

use App\Models\ModemType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ModemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('modemtype.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $modemTypes = ModemType::all();
            return response()->json(['modemTypes' => $modemTypes]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }


    public function add(Request $request): JsonResponse
    {
        $modemType = new ModemType();
        $modemType->name = $request->name;
        $modemType->description = $request->description;
        $modemType->save();

        return response()->json(['status'=>'success', 'message'=>'El Tipo de Modem fue agregado']);    
    }

    public function edit(Request $request): JsonResponse 
    {
        ModemType::where('id', $request->modemTypeId)
            ->update(['name' => $request->name, 'description' => $request->description]);

        return response()->json(['status'=>'success', 'message'=>'El Tipo de Modem fue actualizado']);
    }
    
    public function remove(Request $request): JsonResponse
    {
        ModemType::find($request->modemTypeId)->delete();      

        return response()->json(['status'=>'success']);
    }
}
