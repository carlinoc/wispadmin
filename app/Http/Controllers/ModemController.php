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
        $modems = Modem::select('modem.id', 'modem.MAC', 'modem.MarkCode', 'modem.ConnectionType', 'modem.State', 'modemtype.name as ModemType', 'modem.contractId', 'client.name as clientName', 'client.lastName as clientLastName')
            ->join('modemtype', 'modemtype.id', '=', 'modem.modemtypeId')
            ->join('contract', 'contract.id', '=', 'modem.contractId')
            ->join('client', 'client.id', '=', 'contract.clientId')
            ->get();
        
        $heads = [
            'MAC',
            'Rayado',
            'Tipo de Modem',
            'Conexión',
            'Estado',
            'Titular',
            'Nro. Contrato',
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modem $modem): View
    {
        $modemTypes = ModemType::all();
        return view('modem.edit', ['modem'=>$modem, 'modemTypes'=>$modemTypes]);
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

        $modem->name = $request->Name;
        $modem->DefaultUrl = $request->DefaultUrl;
        $modem->DefaultWifiName = $request->DefaultWifiName;
        $modem->DefaultWifiPassword = $request->DefaultWifiPassword;
        $modem->MarkCode = $request->MarkCode;
        $modem->ConnectionType = $request->ConnectionType;
        $modem->State = $request->State;
        $modem->Description = $request->Description;
        $modem->modemTypeId = $request->modemTypeId;

        $modem->update();

        return redirect()->route('modem.index')->with('success', 'Modem Actualizado');
    }

    public function destroy(Modem $modem)
    {
        //validar si se puede eliminar por las relaciones
        $row = Modem::where('id', $modem->id)->get();
        if($row->count() > 0) {
            if(!is_null($row[0]->photo)){
                File::delete($row[0]->photo);    
            }
        }
        $modem->delete();
        
        return redirect()->route('modem.index')->with('success', 'Modem Eliminado');
    }

    public static function getState($model){
        $_state="";
        switch($model){
            case 1:
                $_state='<small class="badge badge-info">Nuevo</small>';
                break;
            case 2:
                $_state='<small class="badge badge-success">Activo</small>';
                break;    
            case 3:
                $_state='<small class="badge badge-warning">Inactivo</small>';
                break;        
            case 4:
                $_state='<small class="badge badge-danger">Malogrado</small>';
                break;            
        }
        return $_state;
    }

    public static function getConnectionType($connection){
        $_connection="";
        switch($connection){
            case 1:
                $_connection='HFC';
                break;
            case 2:
                $_connection='Fibra';
                break;    
            case 3:
                $_connection='Antena';
                break;        
        }
        return $_connection;
    }

    public static function getImage($photo){
        if(is_null($photo)){
            return "files/image-default.jpg";
        }
        return $photo;
    }
}
