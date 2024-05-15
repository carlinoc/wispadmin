<?php

namespace App\Http\Controllers;

use App\Models\StreamingTv;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\StreamingTvProfile;
use Illuminate\Support\Facades\DB;

class StreamingTvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('streamingtv.index');
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $streamingTvs = StreamingTv::select('streamingtv.id', 'streamingtv.name', 'streamingtv.url', 'streamingtv.email', 'streamingtv.password', 'streamingtv.purchaseprice', DB::raw('count(streamingtvprofile.streamingTvId) as profiles'))
                ->leftJoin('streamingtvprofile', 'streamingtvprofile.streamingTvId', '=', 'streamingtv.id')
                ->groupBy('streamingtv.id', 'streamingtv.name', 'streamingtv.url', 'streamingtv.email', 'streamingtv.password', 'streamingtv.purchaseprice')
                ->get();
            
            return response()->json(['streamingTvs' => $streamingTvs]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }


    public function add(Request $request): JsonResponse
    {
        $streamingTv = new StreamingTv();
        $streamingTv->name = $request->name;
        $streamingTv->url = $request->url;
        $streamingTv->email = $request->email;
        $streamingTv->password = $request->password;
        $streamingTv->purchaseprice = $request->purchaseprice;
        $streamingTv->save();

        return response()->json(['status'=>'success', 'message'=>'El Streaming fue agregado']);    
    }

    public function edit(Request $request): JsonResponse 
    {
        StreamingTv::where('id', $request->streamingTvId)
            ->update(['name' => $request->name, 'url' => $request->url, 'email' => $request->email, 'password' => $request->password, 'purchaseprice' => $request->purchaseprice]);
            

        return response()->json(['status'=>'success', 'message'=>'El Streaming fue actualizado']);
    }
    
    public function remove(Request $request): JsonResponse
    {
        StreamingTv::find($request->streamingTvId)->delete();      

        return response()->json(['status'=>'success']);
    }

    public function detail(Request $request): View
    {
        $streamingtv = StreamingTv::where('id', $request->streamingtvId)->first();

        return view('streamingtv.detail', ['streamingtv' => $streamingtv]);
    }

    public function listprofile(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $streamingTvProfiles = StreamingTvProfile::select('streamingtvprofile.id', 'streamingtvprofile.profile', 'streamingtvprofile.accessCode')
            ->where('streamingtvprofile.streamingTvId', $request->streamingTvId)
            ->get();

            return response()->json(['streamingTvProfiles' => $streamingTvProfiles]);
        } else {
            abort(403, 'You do not have permission to view this page ');
        }
    }

    public function addprofile(Request $request)
    {
        $streamingTvProfile = new StreamingTvProfile();
        $streamingTvProfile->profile = $request->profile;
        $streamingTvProfile->accessCode = $request->accessCode;
        $streamingTvProfile->streamingTvId = $request->streamingTvId;
        $streamingTvProfile->save();
    
        return response()->json(['status'=>'success', 'message'=>'El Streaming fue agregado']);    
    }
    
    public function editprofile(Request $request): JsonResponse 
    {
        StreamingTvProfile::where('id', $request->streamingTvProfileId)
            ->update(['profile' => $request->profile, 'accessCode' => $request->accessCode, 'streamingTvId' => $request->streamingTvId,]);
    
        return response()->json(['status'=>'success', 'message'=>'El Perfil fue actualizado']);
    }
    
    public function removeprofile(Request $request): JsonResponse
    {
        StreamingTvProfile::find($request->streamingTvProfileId)->delete();      
    
        return response()->json(['status'=>'success']);
    }
}
