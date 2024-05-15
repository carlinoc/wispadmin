@extends('adminlte::page')

@section('title', 'Nuevo Mikrotik')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Nuevo Mikrotik</h1>
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
                <form action="{{route('mikrotiks.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="model">Modelo de Mikrotik:</label>
                                    <select class="form-control" name="Model" id="Model" required>
                                        <option value=""> - Seleccione - </option>
                                        <option value="1">Modelo 1</option>
                                        <option value="2">Modelo 2</option>
                                        <option value="3">Modelo 3</option>
                                    </select>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">MAC</label>
                                    <input type="text" class="form-control" id="MAC" name="MAC" placeholder="00:00:00:00:00:00" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Identity</label>
                                    <input type="text" class="form-control" id="Identity" name="Identity" placeholder="Ingresar la Identity" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Url de conexión</label>
                                    <input type="text" class="form-control" id="AccessCodeUrl" name="AccessCodeUrl" placeholder="http://" required>
                                </div>            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Usuario de conexión</label>
                                    <input type="text" class="form-control" id="AccessCodeUser" name="AccessCodeUser" placeholder="Ingrese el usuario de conexión" required>
                                </div>            
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="mac">Contraseña de conexión</label>
                                    <input type="text" class="form-control" id="AccessCodePassword" name="AccessCodePassword" placeholder="Ingrese la contraseña de conexión" required>
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
                                    <select class="form-control" name="state" id="state">
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
                            <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripcion"></textarea>
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