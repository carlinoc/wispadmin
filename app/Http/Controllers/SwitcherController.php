<?php

namespace App\Http\Controllers;

use App\Models\BrandName;
use App\Models\Switcher;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class SwitcherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $brandNames = BrandName::all();

        return view('switcher.index', ['brandNames' => $brandNames]);
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $switchers = Switcher::select('switcher.id', 'switcher.serie', 'switcher.numberOfPorts', 'switcher.state', 'switcher.description', 'switcher.brandNameId', 'brandName.name as brandNameName')
            ->join('brandName','brandName.id', '=', 'switcher.brandNameId')
            ->get();

            return response()->json(['switchers' => $switchers]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function add(Request $request)
    {
        //dd($request);
        $switcher = new Switcher();
        $switcher->serie = $request->serie;
        $switcher->numberOfPorts = $request->numberOfPorts;
        $switcher->state = $request->state;
        $switcher->description = $request->description;
        $switcher->brandNameId = $request->brandNameId;
        $switcher->save();
    
        return response()->json(['status'=>'success', 'message'=>'El switcher fue agregado']);
    }

    public function edit(Request $request): JsonResponse 
    {
        Switcher::where('id', $request->switcherId)
            ->update(['serie' => $request->serie, 'numberOfPorts' => $request->numberOfPorts, 'state' => $request->state, 'description' => $request->description, 'brandNameId' => $request->brandNameId]);

        return response()->json(['status'=>'success', 'message'=>'La información fue actualizada']);
    }

    public function remove(Request $request): JsonResponse
    {
        Switcher::find($request->switcherId)->delete();

        return response()->json(['status'=>'success']);
    }

}
