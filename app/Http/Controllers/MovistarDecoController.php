<?php

namespace App\Http\Controllers;

use App\Models\MovistarDeco;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MovistarDecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $movistarDecos = MovistarDeco::all();
        
        $heads = [
            'ID',
            'CASID',
            'MarkCode',
            'Tipo',
            'Opciones'
        ];
        return view('movistarDeco.index', ['movistarDecos' => $movistarDecos, 'heads' => $heads]);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //try {
            $row = MovistarDeco::where('MAC', $request->MAC)->get();
            if($row->count() == 0) {
                $movistarDeco = new MovistarDeco();

                $movistarDeco->CASID = $request->CASID;
                $movistarDeco->CardNumber = $request->CardNumber;
                $movistarDeco->MarkCode = $request->MarkCode;
                // $movistarDeco->Photo1 = $request->Photo1;
                $movistarDeco->State = $request->State;
                $movistarDeco->DecoType = $request->DecoType;
                $movistarDeco->Description = $request->Description;
                $movistarDeco->TypeOfFault = $request->TypeOfFault;

                $movistarDeco->save();
                
                if($request->hasFile('photo1')){
                    $path = 'files/movistardeco/';
                    $file = time() .'-'. $movistarDeco->id . '.jpg';
                    $success = $request->file('photo1')->move($path, $file);
                    if($success){
                        DB::table('movistarDeco')->where('id', $movistarDeco->id)->update(['photo1' => $path . $file]);
                    }
                }

                return redirect()->route('movistarDeco.index')->with('success', 'Nuevo MovistarDeco agregado');
            }else{
                return redirect()->route('movistarDeco.index')->with('error', 'El MAC ya existe');
            }
        //} catch (Exception $e) {
        //    return redirect()->route('movistarDeco.index')->with('error', 'Ocurrio un error al guardar');
        //}
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MovistarDeco $movistarDeco): View
    {
        return view('movistarDeco.edit', ['mikrotik'=>$movistarDeco]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MovistarDeco $movistarDeco)
    {
        $movistarDeco = MovistarDeco::find($movistarDeco->id);
        if($request->hasFile('photo1')){
            if(!is_null($movistarDeco->photo1)){
                File::delete($movistarDeco->photo1);
            }
            $path = 'files/movistardeco/';
            $file = time() .'-'. $movistarDeco->id . '.jpg';
            $success = $request->file('photo1')->move($path, $file);
            if($success){
                $movistarDeco->photo1 = $path . $file;    
            }
        }

        $movistarDeco->CASID = $request->CASID;
        $movistarDeco->CardNumber = $request->CardNumber;
        $movistarDeco->MarkCode = $request->MarkCode;
        $movistarDeco->Photo1 = $request->Photo1;
        $movistarDeco->State = $request->State;
        $movistarDeco->DecoType = $request->DecoType;
        $movistarDeco->Description = $request->Description;
        $movistarDeco->TypeOfFault = $request->TypeOfFault;
        $movistarDeco->serviceProviderId = $request->serviceProviderId;
        
        $movistarDeco->update();

        return redirect()->route('movistarDeco.index')->with('success', 'MovistarDeco Actualizado');
    }
}
