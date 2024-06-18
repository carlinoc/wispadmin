@extends('adminlte::page')

@section('title', 'Inventario de Modem')

@section('content_header')
    <h1>Inventario de Modem</h1>
@stop

@section('content')
    <div>
        <x-adminlte-card>
            <div class="card-body">
                <x-adminlte-datatable id="dtModem" :heads="$heads" class="hover">
                    @foreach($modems as $modem)
                        <tr>
                            <td>{{ $modem->MAC }}</td>
                            <td>{{ $modem->MarkCode }}</td>
                            <td>{{ $modem->ModemType }}</td>
                            <td>
                                @php
                                    $conn = App\Http\Controllers\ModemController::getConnectionType($modem->ConnectionType);
                                    echo($conn)
                                @endphp
                            </td>
                            <td>
                                @php
                                    $state = App\Http\Controllers\ModemController::getState($modem->State);
                                    echo($state)
                                @endphp
                            </td>
                            <td>{{ $modem->clientName }} {{ $modem->clientLastName }}</td>
                            <td> 
                                <a href="/contract-detail/{{ $modem->contractId }}">{{ $modem->contractId }}</a>
                            </td>
                            <td>
                                <a href="/modem/{{$modem->id}}/edit" class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>

                                <form action="{{route('modem.destroy', $modem)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger removeModem"><i class="far fa-trash-alt"></i></button>
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

        $('.removeModem').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Advertencia",
                text: "Deseas eliminar el Modem?",
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