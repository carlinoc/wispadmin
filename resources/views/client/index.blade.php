@extends('adminlte::page')

@section('title', 'Mantenimiento de Clientes')

@section('content_header')
    <h1>Mantenimiento de Clientes</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newClient" class="btn btn-primary">Crear Nuevo Cliente</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtClient" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('client.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _clientId = $("#clientId");
        let _name = $("#name");
        let _lastName = $("#lastName");
        let _DNI = $("#DNI");
        let _phone = $("#phone");
        let _adress = $("#adress");
        let _email = $("#email");
        let _zoneId = $("#zoneId");
        let _dtClient = $("#dtClient");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        function fetch() {
            $.ajax({
                url: "{{ route('client.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    _ds = data.clients;
                    _dtClient.DataTable({
                        "data": data.clients,
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
                                    return row.name + ' ' + row.lastName;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.DNI;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.phone;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="/client-detail/'+row.id+'" class="btn btn-sm btn-warning detailClient"><i class="far fa-eye"></i></a> <a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editClient"><i class="far fa-edit"></i></a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeClient"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newClient').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Cliente");
            _modal.modal('show');
            
            setTimeout(function(){
                _name.focus();
            }, 300);
        });
        
        function clearForm() {
            _clientId.val("");
            _name.val("");
            _lastName.val("");
            _DNI.val("");
            _phone.val("");
            _adress.val("");
            _email.val("");
            _zoneId.val("").change();
        }
        
        $('#addClient').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre del cliente'],
                ['lastName', 'Ingrese el apellido del cliente'],
                ['DNI', 'Ingrese el DNI cliente'],
                ['phone', 'Ingrese el teléfono del cliente'],
                ['adress', 'Ingrese la dirección del cliente'],
                ['zoneId', 'Ingrese la zona']
            ];

            if(emptyfy(elements)) {
                let clientId = _clientId.val();
                var myform = document.getElementById('frmAddClient');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let route = "{{ route('client.add') }}";
                if(clientId!="") {
                    route = "{{ route('client.edit') }}";
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
                            _dtClient.DataTable().destroy();
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

        _dtClient.on('click', '.editClient', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _clientId.val(id);
                _name.val(name);
                _lastName.val(lastName);
                _DNI.val(DNI)
                _phone.val(phone);
                _adress.val(adress);
                _email.val(email);
                _zoneId.val(zoneId).change();
            }
            
            _modalLabel.text("Editar Cliente");
            _modal.modal('show');
        });
        
        _dtClient.on('click', '.removeClient', function (e) {
            e.preventDefault();
            let clientId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el cliente?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('client.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            clientId:clientId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtClient.DataTable().destroy();
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