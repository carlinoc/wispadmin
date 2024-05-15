@extends('adminlte::page')

@section('title', 'Perfiles de la cuenta')

@section('content_header')
<div class="row">
    <div class="col-md-auto">
        <h1>Proveedor: {{$provider->name}}</h1>    
    </div>
    <div class="col">
        <a href="{{route('provider.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
    </div>
</div>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newService" class="btn btn-primary">Agregar Servicio</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtServiceProvider" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>Servicio</th>
                        <th>Descripción</th>
                        <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('provider.service-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _serviceproviderId = $("#serviceProviderId");
        let _name = $("#name");
        let _description = $("#description");
        let _providerId = $("#providerId");

        let _dtServiceProvider = $("#dtServiceProvider");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        function fetch() {
            $.ajax({
                url: "{{ route('provider.listservice') }}",
                type: "Get",
                data: {providerId:{{$provider->id}}},
                dataType: "json",
                success: function(data) {
                    _ds = data.services;
                    _dtServiceProvider.DataTable({
                        "data": data.services,
                        "responsive": true,
                        order: [[0, 'desc']],
                        "columns": [
                            {
                                "render": function(data, type, row, meta) {
                                    return row.id;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.name;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.description;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editService">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeService"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newService').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Servicio");
            _modal.modal('show');
            
            setTimeout(function(){
                _name.focus();
            }, 300);
        });
        
        function clearForm() {
            _serviceproviderId.val("");
            _name.val("");
            _description.val("");
        }
        
        $('#addServiceProvider').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre del servicio']
            ];

            if(emptyfy(elements)) {
                let serviceproviderId = _serviceproviderId.val();
                var myform = document.getElementById('frmAddServiceProvider');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);
                
                let route = "{{ route('provider.addservice') }}";
                if(serviceproviderId!="") {
                    route = "{{ route('provider.editservice') }}";
                }

                $.ajax({
                    url:route,
                    method:'post',
                    data:form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success:function(res){
                        if(res.status=="success"){
                            _modal.modal('hide');
                            clearForm();
                            _dtServiceProvider.DataTable().destroy();
                            fetch();
                        }
                        if(res.status=="error"){
                            showErrorMsg(res.message);
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }
        });

        _dtServiceProvider.on('click', '.editService', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _serviceproviderId.val(id);
                _name.val(name);
                _description.val(description);
            }
            
            _modalLabel.text("Editar Servicio");
            _modal.modal('show');
        });
        
        _dtServiceProvider.on('click', '.removeService', function (e) {
            e.preventDefault();
            let serviceProviderId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el servicio?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('provider.removeservice') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            serviceProviderId:serviceProviderId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtServiceProvider.DataTable().destroy();
                                fetch();
                            }
                        },error:function(err){
                            alert(err);
                        }
                    });         
                }
            });
        });

        
    });     
</script>        
@stop
