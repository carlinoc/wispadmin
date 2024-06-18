@extends('adminlte::page')

@section('title', 'Nuevo MovistarDeco')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Nuevo MovistarDeco</h1>
        </div>
        <div class="col">
            <a href="{{route('movistarDeco.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <form action="{{route('movistarDeco.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Tipo de MovistarDeco</label>
                                    <x-adminlte-select2 id="movistarDecoTypeId" name="movistarDecoTypeId" label-class="text-lightblue" data-placeholder="Seleccione un tipo">
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                        </x-slot>
                                        <option value=""></option>
                                        @foreach($movistarDecoTypes as $movistarDecoType)
                                            <option value="{{$movistarDecoType->id}}">{{$movistarDecoType->name}}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="Name">Name</label>
                                    <input type="text" class="form-control" id="Name" name="Name" placeholder="Ingrese el nombre" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="MAC">MAC</label>
                                    <input type="text" class="form-control" id="MAC" name="MAC" placeholder="00:00:00:00:00:00" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Url default de conexión</label>
                                    <input type="text" class="form-control" id="DefaultUrl" name="DefaultUrl" placeholder="http://" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Nombre de Wifi</label>
                                    <input type="text" class="form-control" id="DefaultWifiName" name="DefaultWifiName" placeholder="Ingrese el usuario de conexión" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label>Contraseña de Wifi</label>
                                    <input type="text" class="form-control" id="DefaultWifiPassword" name="DefaultWifiPassword" placeholder="Ingrese la contraseña de conexión" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="MarkCode">MarkCode</label>
                                    <input type="text" class="form-control" id="MarkCode" name="MarkCode" placeholder="Ingrese el usuario de conexión" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="ConnectionType">Tipo de conexión</label>
                                    <select class="form-control" name="ConnectionType" id="ConnectionType">
                                        <option value=""> - Seleccione - </option>
                                        <option value="1">Tipo 1</option>
                                        <option value="2">Tipo 2</option>
                                        <option value="3">Tipo 3</option>
                                    </select>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="photo1">Foto</label>
                                    <input class="form-control" name="photo1" type="file" id="photo1">
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="state">Estado</label>
                                    <select class="form-control" name="State" id="State">
                                        <option value=""> - Seleccione - </option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        <option value="3">Malogrado</option>
                                    </select>
                                </div>            
                            </div>
                        </div>
                        <div class="for-group mt-2">
                            <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripcion</label>
                            <textarea class="form-control" rows="3" id="Description" name="Description" placeholder="Breve descripcion"></textarea>
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
