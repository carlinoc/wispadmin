@extends('adminlte::page')

@section('title', 'Editar Modem')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Editar Modem</h1>
        </div>
        <div class="col">
            <a href="{{route('modem.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <form action="{{route('modem.update', $modem)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Tipo de Modem</label>
                                    <x-adminlte-select2 id="modemTypeId" name="modemTypeId" label-class="text-lightblue" data-placeholder="Seleccione un tipo">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                        </x-slot>
                                        <option value=""></option>
                                        @foreach($modemTypes as $modemType)
                                            @if ($modemType->id==$modem->modemTypeId)
                                                <option selected value="{{$modemType->id}}">{{$modemType->name}}</option>
                                            @else
                                                <option value="{{$modemType->id}}">{{$modemType->name}}</option>
                                            @endif
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="Name">Name</label>
                                    <input type="text" class="form-control" id="Name" name="Name" value="{{$modem->name}}" placeholder="Ingrese el nombre" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="MAC">MAC</label>
                                    <input type="text" class="form-control" id="MAC" name="MAC" value="{{$modem->MAC}}" placeholder="00:00:00:00:00:00" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Url default de conexión</label>
                                    <input type="text" class="form-control" id="DefaultUrl" name="DefaultUrl" value="{{$modem->DefaultUrl}}" placeholder="http://" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Nombre de Wifi</label>
                                    <input type="text" class="form-control" id="DefaultWifiName" name="DefaultWifiName" value="{{$modem->DefaultWifiName}}" placeholder="Ingrese el usuario de conexión" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Contraseña de Wifi</label>
                                    <input type="text" class="form-control" id="DefaultWifiPassword" name="DefaultWifiPassword" value="{{$modem->DefaultWifiPassword}}" placeholder="Ingrese la contraseña de conexión" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="MarkCode">Rayado</label>
                                    <input type="text" class="form-control" id="MarkCode" name="MarkCode" value="{{$modem->MarkCode}}" placeholder="Ingrese el usuario de conexión" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="ConnectionType">Tipo de conexión</label>
                                    <select class="form-control" name="ConnectionType" id="ConnectionType">
                                        <option value=""> - Seleccione - </option>
                                        <option value="1" @selected("1"==$modem->ConnectionType)>HFC</option>
                                        <option value="2" @selected("2"==$modem->ConnectionType)>Fibra</option>
                                        <option value="3" @selected("3"==$modem->ConnectionType)>Antena</option>
                                    </select>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="photo">Foto</label>
                                    <input class="form-control" name="photo" type="file" id="photo">
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="state">Estado</label>
                                    <select class="form-control" name="State" id="State">
                                        <option value=""> - Seleccione - </option>
                                        <option value="1" @selected("1"==$modem->State)>Nuevo</option>
                                        <option value="2" @selected("2"==$modem->State)>Activo</option>
                                        <option value="3" @selected("3"==$modem->State)>Inactivo</option>
                                        <option value="4" @selected("4"==$modem->State)>Malogrado</option>
                                    </select>
                                </div>            
                            </div>
                        </div>
                        <div class="for-group mt-2 text-center">
                            @php
                                $photo = App\Http\Controllers\ModemController::getImage($modem->photo);
                            @endphp
                            <img src="/{{ $photo }}" class="img-fluid border" style="width: 150px" />
                        </div>
                        <div class="for-group mt-2">
                            <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripcion</label>
                            <textarea class="form-control" rows="3" id="Description" name="Description" placeholder="Breve descripcion">{{$modem->Description}}</textarea>
                        </div>
                    </div>    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div> 
    </div> 
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop