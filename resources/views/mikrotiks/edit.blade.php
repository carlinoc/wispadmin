@extends('adminlte::page')

@section('title', 'Editar Mikrotik')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Editar Mikrotik</h1>
        </div>
        <div class="col">
            <a href="{{route('mikrotiks.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <form action="{{route('mikrotiks.update', $mikrotik)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="model">Modelo de Mikrotik:</label>
                                    <select class="form-control" name="Model" id="Model">
                                        <option value=""> - Seleccione - </option>
                                        <option value="1" @selected("1"==$mikrotik->Model)>Modelo 1</option>
                                        <option value="2" @selected("2"==$mikrotik->Model)>Modelo 2</option>
                                        <option value="3" @selected("3"==$mikrotik->Model)>Modelo 3</option>
                                    </select>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">MAC</label>
                                    <input type="text" class="form-control" id="MAC" name="MAC" value="{{$mikrotik->MAC}}" placeholder="00:00:00:00:00:00" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Identity</label>
                                    <input type="text" class="form-control" id="Identity" name="Identity" value="{{$mikrotik->Identity}}" placeholder="Ingresar la Identity" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Url de conexión</label>
                                    <input type="text" class="form-control" id="AccessCodeUrl" name="AccessCodeUrl" value="{{$mikrotik->AccessCodeUrl}}" placeholder="http://" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Usuario de conexión</label>
                                    <input type="text" class="form-control" id="AccessCodeUser" name="AccessCodeUser" value="{{$mikrotik->AccessCodeUser}}" placeholder="Ingrese el usuario de conexión" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Contraseña de conexión</label>
                                    <input type="text" class="form-control" id="AccessCodePassword" name="AccessCodePassword" value="{{$mikrotik->AccessCodePassword}}" placeholder="Ingrese la contraseña de conexión" required>
                                </div>            
                            </div>
                        </div>
                        <div class="for-group mt-2 text-center">
                            @php
                                $photo = App\Http\Controllers\MikrotikController::getImage($mikrotik->photo);
                            @endphp
                            <img src="/{{ $mikrotik->photo }}" class="img-fluid border" style="width: 150px" />
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
                                    <select class="form-control" name="state" id="state">
                                        <option value=""> - Seleccione - </option>
                                        <option value="1" @selected("1"==$mikrotik->State)>Activo</option>
                                        <option value="2" @selected("2"==$mikrotik->State)>Inactivo</option>
                                        <option value="3" @selected("3"==$mikrotik->State)>Malogrado</option>
                                    </select>
                                </div>            
                            </div>
                        </div>
                        <div class="for-group mt-2">
                            <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripcion</label>
                            <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripcion">{{$mikrotik->Description}}</textarea>
                        </div>
                    </div>    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div> 
    </div> 
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop