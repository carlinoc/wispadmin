@extends('adminlte::page')

@section('title', 'Inventario de Mikrotiks')

@section('content_header')
    <h1>Inventario de Mikrotiks</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="/mikrotiks/create" class="btn btn-primary">Nuevo Mikrotik</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <x-adminlte-datatable id="dtMikrotiks" :heads="$heads" class="hover">
                    @foreach($mikrotiks as $mikrotik)
                        <tr>
                            <td>{{ $mikrotik->id }}</td>
                            <td>
                                @php
                                    $model = App\Http\Controllers\MikrotikController::getModel($mikrotik->Model);
                                @endphp
                                {{ $model }}
                            </td>
                            <td>{{ $mikrotik->MAC }}</td>
                            <td>{{ $mikrotik->Identity }}</td>
                            <td>
                                @php
                                    $state = App\Http\Controllers\MikrotikController::getState($mikrotik->State);
                                    echo($state)
                                @endphp
                            </td>
                            <td>
                                <a href="/mikrotiks/{{$mikrotik->id}}/edit" class="btn btn-sm btn-info">Editar</a>

                                <form action="{{route('mikrotiks.destroy', $mikrotik)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger removeMikrotik"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </x-adminlte-card>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    $(document).ready(function() {

        $('.removeMikrotik').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Advertencia",
                text: "Deseas eliminar el Mikrotik?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    var form = $(this).parent();
                    $(form).submit();        
                }
            });
        });

        @if (Session::get('success'))
            showSuccessMsg("{{Session::get('success')}}");
        @endif

        @if (Session::get('error'))
            showErrorMsg("{{Session::get('error')}}");
        @endif
    });    
</script>
@stop