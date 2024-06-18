@extends('adminlte::page')

@section('title', 'Inventario de MovistarDeco')

@section('content_header')
    <h1>Inventario de MovistarDeco</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="/movistardeco/create" class="btn btn-primary">Nuevo MovistarDeco</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <x-adminlte-datatable id="dtMovistarDeco" :heads="$heads" class="hover">
                    @foreach($movistarDecos as $movistarDeco)
                        <tr>
            <td>{{ $movistarDeco->id }}</td>
            <td>{{ $movistarDeco->CASID }}</td>
            <td>{{ $movistarDeco->CardNumber }}</td>
            <td>{{ $movistarDeco->MarkCode }}</td>
            <td>{{ $movistarDeco->Photo1 }}</td>
            <td>{{ $movistarDeco->State }}</td>
            <td>{{ $movistarDeco->DecoType }}</td>
            <td>{{ $movistarDeco->Description }}</td>
            <td>{{ $movistarDeco->TypeOfFault }}</td>
            <td>{{ $movistarDeco->serviceProviderId }}</td>

                            // <td>{{ $movistarDeco->id }}</td>
                            // <td>{{ $movistarDeco->name }}</td>
                            // <td>{{ $movistarDeco->MAC }}</td>
                            // <td>{{ $movistarDeco->Markcode }}</td>
                            // <td>{{ $movistarDeco->movistarDecoTypeId }}</td>
                            <td>
                                <a href="/movistardeco/{{$movistarDeco->id}}/edit" class="btn btn-sm btn-info">Editar</a>

                                <form action="{{route('movistarDeco.destroy', $movistarDeco)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger removeMovistarDeco"><i class="far fa-trash-alt"></i></button>
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

        $('.removeMovistarDeco').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Advertencia",
                text: "Deseas eliminar el MovistarDeco?",
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
