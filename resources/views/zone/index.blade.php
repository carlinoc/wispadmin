@extends('adminlte::page')

@section('title', 'Mantenimiento de Zonas')

@section('content_header')
    <h1>Mantenimiento de Zonas</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newZone" class="btn btn-primary">Crear Nueva Zona</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtZone" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Alias</th>
                            <th>Distrito</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('zone.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _zoneId = $("#zoneId");
        let _name = $("#name");
        let _nickName = $("#nickName");
        let _district = $("#district");
        let _dtZone = $("#dtZone");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        function fetch() {
            $.ajax({
                url: "{{ route('zone.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    _ds = data.zones;
                    _dtZone.DataTable({
                        "data": data.zones,
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
                                    return row.nickName;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return getDistrict(row.district);
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editZone">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeZone"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newZone').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nueva Zona");
            _modal.modal('show');

            setTimeout(function(){
                _name.focus();
            }, 300);
        });

        $('#addZone').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre de la zona'],
                ['nickName', 'Ingrese el alias de la zona'],
                ['district', 'Ingrese el distrito']
            ];

            if(emptyfy(elements)) {
                let zoneId = _zoneId.val();
                var myform = document.getElementById('frmAddZone');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let route = "{{ route('zone.add') }}";
                if(zoneId!="") {
                    route = "{{ route('zone.edit') }}";
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
                            _dtZone.DataTable().destroy();
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

        _dtZone.on('click', '.editZone', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _zoneId.val(id);
                _name.val(name);
                _nickName.val(nickName);
                _district.val(district);
            }
            
            _modalLabel.text("Editar Zona");
            _modal.modal('show');
        });    

        _dtZone.on('click', '.removeZone', function (e) {
            e.preventDefault();
            let zoneId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar la zona?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('zone.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            zoneId:zoneId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtZone.DataTable().destroy();
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
            _zoneId.val("");
            _name.val("");
            _nickName.val("");
            _district.val("");
        }

        function getDistrict(code){
            $district="";
            switch(code) {
                case 'CU':
                    $district="Cusco"; 
                    break;
                case 'WA':
                    $district="Wanchaq"; 
                    break;
                case 'SS':
                    $district="San Sebastian"; 
                    break;
                case 'SJ':
                    $district="San Jeronimo"; 
                    break;    
            }    
            return $district;
        } 
    });     
</script>        
@stop