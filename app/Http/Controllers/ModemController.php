<?php

namespace App\Http\Controllers;

use App\Models\Modem;
use App\Models\ModemType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $modems = Modem::all();
        
        $heads = [
            'ID',
            'Name',
            'MAC',
            'Rayado',
            'Tipo',
            'Opciones'
        ];
        return view('modem.index', ['modems' => $modems, 'heads' => $heads]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $modemTypes = ModemType::all();
        return view('modem.create', ['modemTypes' => $modemTypes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //try {
            $row = Modem::where('MAC', $request->MAC)->get();
            if($row->count() == 0) {
                $modem = new Modem();
                $modem->Name = $request->Name;
                $modem->MAC = $request->MAC;
                $modem->DefaultUrl = $request->DefaultUrl;
                $modem->DefaultWifiName = $request->DefaultWifiName;
                $modem->DefaultWifiPassword = $request->DefaultWifiPassword;
                $modem->MarkCode = $request->MarkCode;
                $modem->ConnectionType = $request->ConnectionType;
                $modem->State = $request->State;
                $modem->Description = $request->Description;
                $modem->modemTypeId = $request->modemTypeId;

                $modem->save();
                
                if($request->hasFile('photo')){
                    $path = 'files/modem/';
                    $file = time() .'-'. $modem->id . '.jpg';
                    $success = $request->file('photo')->move($path, $file);
                    if($success){
                        DB::table('modem')->where('id', $modem->id)->update(['photo' => $path . $file]);
                    }
                }

                return redirect()->route('modem.index')->with('success', 'Nuevo Modem agregado');
            }else{
                return redirect()->route('modem.index')->with('error', 'El MAC ya existe');
            }
        //} catch (Exception $e) {
        //    return redirect()->route('modem.index')->with('error', 'Ocurrio un error al guardar');
        //}
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modem $modem): View
    {
        return view('modem.edit', ['mikrotik'=>$modem]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modem $modem)
    {
        $modem = Modem::find($modem->id);
        if($request->hasFile('photo')){
            if(!is_null($modem->photo)){
                File::delete($modem->photo);
            }
            $path = 'files/modem/';
            $file = time() .'-'. $modem->id . '.jpg';
            $success = $request->file('photo')->move($path, $file);
            if($success){
                $modem->photo = $path . $file;    
            }
        }

        $modem->Model = $request->Model;
        $modem->MAC = $request->MAC;
        $modem->Identity = $request->Identity;
        $modem->AccessCodeUrl = $request->AccessCodeUrl;
        $modem->AccessCodeUser = $request->AccessCodeUser;
        $modem->MarkCode= $request->AccessCodePassword;
        $modem->State = $request->state;
        $modem->description = $request->description;

        $modem->update();

        return redirect()->route('modem.index')->with('success', 'Modem Actualizado');
    }
}
