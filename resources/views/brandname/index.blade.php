@extends('adminlte::page')

@section('title', 'Mantenimiento de Marca')

@section('content_header')
    <h1>Mantenimiento de Marca</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newBrandName" class="btn btn-primary">Crear Nuevo Marca</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtBrandName" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>description</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('brandname.add-modal')

@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _brandNameId = $("#brandNameId");
        let _name = $("#name");
        let _description = $("#description");
        let _dtBrandName = $("#dtBrandName");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        function fetch() {
            $.ajax({
                url: "{{ route('brandname.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    _ds = data.brandNames;
                    _dtBrandName.DataTable({
                        "data": data.brandNames,
                        "responsive": true,
                        order: [[0, 'desc']],
                        "columns": [
                            {
                                "render": function(data, type, row, meta) {
                                    return row.id;
                                }
                            },
                            {"render": function(data, type, row, meta) {return row.name;}},
                            {"render": function(data, type, row, meta) {return row.description;}},
                                                        
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editBrandName">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeBrandName"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newBrandName').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Marca");
            _modal.modal('show');

            setTimeout(function(){
                _name.focus();
            }, 300);
        });

        $('#addBrandName').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre del Marca']
            ];

            if(emptyfy(elements)) {
                let brandNameId = _brandNameId.val();
                var myform = document.getElementById('frmAddBrandName');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let route = "{{ route('brandname.add') }}";
                if(brandNameId!="") {
                    route = "{{ route('brandname.edit') }}";
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
                            _dtBrandName.DataTable().destroy();
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

        _dtBrandName.on('click', '.editBrandName', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _brandNameId.val(id);
                _name.val(name);
                _description.val(description);
            }
            _modalLabel.text("Editar Marca");
            _modal.modal('show');
        });    


        _dtBrandName.on('click', '.removeBrandName', function (e) {
            e.preventDefault();
            let brandNameId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar Marca?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('brandname.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            brandNameId:brandNameId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtBrandName.DataTable().destroy();
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
            _brandNameId.val("");
            _name.val("");
            _description.val("");
        }
    });     
</script>      
@stop

