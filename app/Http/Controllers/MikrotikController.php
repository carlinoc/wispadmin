<?php

namespace App\Http\Controllers;

use App\Models\Mikrotik;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MikrotikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $mikrotiks = Mikrotik::all();
        
        $heads = [
            'ID',
            'Modelo',
            'MAC',
            'Identity',
            'Estado',
            'Opciones'
        ];
        return view('mikrotiks.index', ['mikrotiks' => $mikrotiks, 'heads' => $heads]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('mikrotiks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $row = Mikrotik::where('MAC', $request->MAC)->get();
            if($row->count() == 0) {
                $mikrotik = new Mikrotik();
                $mikrotik->Model = $request->Model;
                $mikrotik->MAC = $request->MAC;
                $mikrotik->Identity = $request->Identity;
                $mikrotik->AccessCodeUrl = $request->AccessCodeUrl;
                $mikrotik->AccessCodeUser = $request->AccessCodeUser;
                $mikrotik->AccessCodePassword = $request->AccessCodePassword;
                $mikrotik->State = $request->state;
                $mikrotik->description = $request->description;

                $mikrotik->save();
                
                if($request->hasFile('photo')){
                    $path = 'files/mikrotiks/';
                    $file = time() .'-'. $mikrotik->id . '.jpg';
                    $success = $request->file('photo')->move($path, $file);
                    if($success){
                        DB::table('mikrotik')->where('id', $mikrotik->id)->update(['photo' => $path . $file]);
                    }
                }

                return redirect()->route('mikrotiks.index')->with('success', 'Nuevo Mikrotik agregado');
            }else{
                return redirect()->route('mikrotiks.index')->with('error', 'El MAC ya existe');
            }
        } catch (Exception $e) {
            return redirect()->route('mikrotiks.index')->with('error', 'Ocurrio un error al guardar');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mikrotik $mikrotik): View
    {
        return view('mikrotiks.edit', ['mikrotik'=>$mikrotik]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mikrotik $mikrotik)
    {
        $mikrotik = Mikrotik::find($mikrotik->id);
        if($request->hasFile('photo')){
            if(!is_null($mikrotik->photo)){
                File::delete($mikrotik->photo);
            }
            $path = 'files/mikrotiks/';
            $file = time() .'-'. $mikrotik->id . '.jpg';
            $success = $request->file('photo')->move($path, $file);
            if($success){
                $mikrotik->photo = $path . $file;    
            }
        }

        $mikrotik->Model = $request->Model;
        $mikrotik->MAC = $request->MAC;
        $mikrotik->Identity = $request->Identity;
        $mikrotik->AccessCodeUrl = $request->AccessCodeUrl;
        $mikrotik->AccessCodeUser = $request->AccessCodeUser;
        $mikrotik->AccessCodePassword = $request->AccessCodePassword;
        $mikrotik->State = $request->state;
        $mikrotik->description = $request->description;

        $mikrotik->update();

        return redirect()->route('mikrotiks.index')->with('success', 'Mikrotik Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mikrotik $mikrotik)
    {
        //validar si se puede eliminar por las relaciones
        $row = Mikrotik::where('id', $mikrotik->id)->get();
        if($row->count() > 0) {
            if(!is_null($row[0]->photo)){
                File::delete($row[0]->photo);    
            }
        }
        $mikrotik->delete();
        
        return redirect()->route('mikrotiks.index')->with('success', 'Mikrotik eliminado');
    }

    public static function getImage($photo){
        if(is_null($photo)){
            return "images/movie-default.jpg";
        }
        return $photo;
    }

    public static function getModel($model){
        $_model="";
        switch($model){
            case 1:
                $_model="Modelo 1";
                break;
            case 2:
                $_model="Modelo 2";
                break;    
            case 3:
                $_model="Modelo 3";
                break;        
        }
        return $_model;
    }

    public static function getState($model){
        $_state="";
        switch($model){
            case 1:
                $_state='<small class="badge badge-success">Activo</small>';
                break;
            case 2:
                $_state='<small class="badge badge-warning">Inactivo</small>';
                break;    
            case 3:
                $_state='<small class="badge badge-danger">Malogrado</small>';
                break;        
        }
        return $_state;
    }
}
