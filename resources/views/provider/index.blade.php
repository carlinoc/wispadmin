@extends('adminlte::page')

@section('title', 'Mantenimiento de Proveedores')

@section('content_header')
    <h1>Mantenimiento de Proveedores</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newProvider" class="btn btn-primary">Crear Nuevo Proveedor</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtProvider" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Contacto</th>
                            <th>Contacto Telf</th>
                            <th>Zona</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('provider.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _providerId = $("#providerId");
        let _name = $("#name");
        let _phone = $("#phone");
        let _contactName = $("#contactName");
        let _contactPhone = $("#contactPhone");
        let _description = $("#description");
        let _zoneId = $("#zoneId");
        let _dtProvider = $("#dtProvider");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        function fetch() {
            $.ajax({
                url: "{{ route('provider.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    _ds = data.providers;
                    _dtProvider.DataTable({
                        "data": data.providers,
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
                                    return row.phone;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.contactName;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.contactPhone;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    
                                    return row.zoneName;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editProvider">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeProvider"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newProvider').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Proveedor");
            _modal.modal('show');
            
            setTimeout(function(){
                _name.focus();
            }, 300);
        });
        
        function clearForm() {
            _providerId.val("");
            _name.val("");
            _phone.val("");
            _contactName.val("");
            _contactPhone.val("");
            _description.val("");
            _zoneId.val("").change();
        }
        
        $('#addProvider').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre del proveedor'],
                ['phone', 'Ingrese el telefono del proveedor'],
                ['contactName', 'Ingrese el nombre del contacto'],
                ['contactPhone', 'Ingrese el teléfono del contacto'],
                ['zoneId', 'Ingrese la zona']
            ];

            if(emptyfy(elements)) {
                let providerId = _providerId.val();
                var myform = document.getElementById('frmAddProvider');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let route = "{{ route('provider.add') }}";
                if(providerId!="") {
                    route = "{{ route('provider.edit') }}";
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
                            _dtProvider.DataTable().destroy();
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

        _dtProvider.on('click', '.editProvider', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _providerId.val(id);
                _name.val(name);
                _phone.val(phone);
                _contactName.val(contactName);
                _contactPhone.val(contactPhone);
                _description.val(description);
                _zoneId.val(zoneId).change();
            }
            
            _modalLabel.text("Editar Proveedor");
            _modal.modal('show');
        });
        
        _dtProvider.on('click', '.removeProvider', function (e) {
            e.preventDefault();
            let providerId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el porveedor?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('provider.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            providerId:providerId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtProvider.DataTable().destroy();
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