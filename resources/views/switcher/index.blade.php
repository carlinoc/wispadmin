@extends('adminlte::page')

@section('title', 'Mantenimiento de switcher')

@section('content_header')
    <h1>Mantenimiento de switcher</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newSwitcher" class="btn btn-primary">Crear Nuevo switcher</a>
            </div>
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtSwitcher" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>Serie</th>
                        <th>Nro puertos</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('switcher.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _switcherId = $("#switcherId");
        let _serie = $("#serie");
        let _numberOfPorts = $("#numberOfPorts");
        let _state = $("#state");
        let _description = $("#description");
        let _brandNameId = $("#brandNameId");
        let _dtSwitcher = $("#dtSwitcher");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        _numberOfPorts.inputFilter(function(value) {return /^-?\d*[.,]?\d*$/.test(value);}, "Ingrese el numero");

        function fetch() {
            $.ajax({
                url: "{{ route('switcher.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    _ds = data.switchers;
                    _dtSwitcher.DataTable({
                        "data": data.switchers,
                        "responsive": true,
                        order: [[0, 'desc']],
                        "columns": [
                            {
                                "render": function(data, type, row, meta) {
                                    return row.id;
                                }
                            },
                            {"render": function(data, type, row, meta) {return row.serie;}},
                            {"render": function(data, type, row, meta) {return row.numberOfPorts;}},
                            {"render": function(data, type, row, meta) {return getStateFromDevice(row.state);}},
                            {"render": function(data, type, row, meta) {return row.description;}},
                            {
                                "render": function(data, type, row, meta) {
                                    return row.brandNameName;
                                }
                            },
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

        $('#newSwitcher').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo registro");
            _modal.modal('show');
            
            setTimeout(function(){
                _serie.focus();
            }, 300);
        });
        
        function clearForm() {
            _switcherId.val("");
            _serie.val("");
            _numberOfPorts.val("");
            _state.val("");
            _description.val("");
            _brandNameId.val("").change();
        }
        
        $('#addSwitcher').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['serie', 'Ingrese información'],
                ['brandNameId', 'Ingrese la Marca']
            ];

            if(emptyfy(elements)) {
                let switcherId = _switcherId.val();
                var myform = document.getElementById('frmAddSwitcher');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                console.log(switcherId);
                let route = "{{ route('switcher.add') }}";
                if(switcherId!="") {
                    route = "{{ route('switcher.edit') }}";
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
                            _dtSwitcher.DataTable().destroy();
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

        _dtSwitcher.on('click', '.editBrandName', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _switcherId.val(id);
                _serie.val(serie);
                _numberOfPorts.val(numberOfPorts);
                _state.val(state);
                _description.val(description);
                _brandNameId.val(brandNameId).change();
            }

            _modalLabel.text("Editar información");
            _modal.modal('show');
        });

        _dtSwitcher.on('click', '.removeBrandName', function (e) {
            e.preventDefault();
            let switcherId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el registro?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('switcher.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            switcherId:switcherId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtSwitcher.DataTable().destroy();
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

