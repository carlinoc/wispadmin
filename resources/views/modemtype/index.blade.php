@extends('adminlte::page')

@section('title', 'Mantenimiento de Tipos de Modem')

@section('content_header')
    <h1>Mantenimiento de Tipos de Modem</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newModemType" class="btn btn-primary">Crear Nuevo Tipo de Modem</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtModemType" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('modemtype.add-modal')

@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _modemTypeId = $("#modemTypeId");
        let _name = $("#name");
        let _description = $("#description");
        let _dtModemType = $("#dtModemType");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        function fetch() {
            $.ajax({
                url: "{{ route('modemtype.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    _ds = data.modemTypes;
                    _dtModemType.DataTable({
                        "data": data.modemTypes,
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
                                    return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editModemType">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeModemType"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newModemType').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Tipo de Modem");
            _modal.modal('show');

            setTimeout(function(){
                _name.focus();
            }, 300);
        });

        $('#addModemType').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre del Tipo de Modem']
            ];

            if(emptyfy(elements)) {
                let modemTypeId = _modemTypeId.val();
                var myform = document.getElementById('frmAddModemType');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let route = "{{ route('modemtype.add') }}";
                if(modemTypeId!="") {
                    route = "{{ route('modemtype.edit') }}";
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
                            _dtModemType.DataTable().destroy();
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

        _dtModemType.on('click', '.editModemType', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _modemTypeId.val(id);
                _name.val(name);
                _description.val(description);
            }
            _modalLabel.text("Editar Tipo de Modem");
            _modal.modal('show');
        });    


        _dtModemType.on('click', '.removeModemType', function (e) {
            e.preventDefault();
            let modemTypeId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar Tipo de Modem?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('modemtype.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            modemTypeId:modemTypeId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtModemType.DataTable().destroy();
                                fetch();
                            }
                        },error:function(err){
                            alert(err);
                        }
                    });         
                }
            });
        });


        function clearForm() {
            _modemTypeId.val("");
            _name.val("");
            _description.val("");
        }
    });     
</script>      
@stop