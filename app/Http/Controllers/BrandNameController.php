<?php

namespace App\Http\Controllers;

use App\Models\BrandName;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BrandNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('brandname.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $brandNames = BrandName::all();
            return response()->json(['brandNames' => $brandNames]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }


    public function add(Request $request): JsonResponse
    {
        $brandName = new BrandName();
        $brandName->name = $request->name;
        $brandName->description = $request->description;
        $brandName->save();

        return response()->json(['status'=>'success', 'message'=>'La marca del producto fue agregad@']);
    }

    public function edit(Request $request): JsonResponse 
    {
        BrandName::where('id', $request->brandNameId)
            ->update(['name' => $request->name, 'description' => $request->description]);
            

        return response()->json(['status'=>'success', 'message'=>'La marca del producto fue actualizad@']);
    }
    
    public function remove(Request $request): JsonResponse
    {
        BrandName::find($request->brandNameId)->delete();      

        return response()->json(['status'=>'success']);
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
    public function show(BrandName $brandName)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BrandName $brandName)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandName $brandName)
    {
        //
    }
}
