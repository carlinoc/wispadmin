@extends('adminlte::page')

@section('title', 'Perfiles de la cuenta')

@section('content_header')
<div class="row">
    <div class="col-md-auto">
        <h1>Cuenta: {{$streamingtv->name}}</h1>    
    </div>
    <div class="col">
        <a href="{{route('streamingtv.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
    </div>
</div>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newStreamingTvProfile" class="btn btn-primary">Agregar Perfil</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtStreamingTvProfile" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                        <th>Id</th>
                        <th>Perfil</th>
                        <th>PIN</th>
                        <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('streamingtv.profile-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _streamingtvprofileId = $("#streamingTvProfileId");
        let _profile = $("#profile");
        let _accessCode = $("#accessCode");
        let _streamingTvId = $("#streamingTvId");

        let _dtStreamingTvProfile = $("#dtStreamingTvProfile");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        function fetch() {
            $.ajax({
                url: "{{ route('streamingtv.listprofile') }}",
                type: "Get",
                data: {streamingTvId:{{$streamingtv->id}}},
                dataType: "json",
                success: function(data) {
                    _ds = data.streamingTvProfiles;
                    _dtStreamingTvProfile.DataTable({
                        "data": data.streamingTvProfiles,
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
                                    return row.profile;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.accessCode;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editStreamingTv">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeStreamingTv"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newStreamingTvProfile').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo perfil");
            _modal.modal('show');
            
            setTimeout(function(){
                _profile.focus();
            }, 300);
        });
        
        function clearForm() {
            _streamingtvprofileId.val("");
            _profile.val("");
            _accessCode.val("");
            //_streamingTvId.val("").change();
        }
        
        $('#addStreamingTvProfile').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['profile', 'Ingrese el nombre del perfil'],
                ['accessCode', 'Ingrese el código del perfil']
            ];

            if(emptyfy(elements)) {
                let streamingtvprofileId = _streamingtvprofileId.val();
                var myform = document.getElementById('frmAddStreamingTvProfile');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                console.log(streamingtvprofileId);
                let route = "{{ route('streamingtv.addprofile') }}";
                if(streamingtvprofileId!="") {
                    route = "{{ route('streamingtv.editprofile') }}";
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
                            _dtStreamingTvProfile.DataTable().destroy();
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

        _dtStreamingTvProfile.on('click', '.editStreamingTv', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _streamingtvprofileId.val(id);
                _profile.val(profile);
                _accessCode.val(accessCode);
            }
            
            _modalLabel.text("Editar perfil");
            _modal.modal('show');
        });
        
        _dtStreamingTvProfile.on('click', '.removeStreamingTv', function (e) {
            e.preventDefault();
            let streamingTvProfileId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el perfil?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('streamingtv.removeprofile') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            streamingTvProfileId:streamingTvProfileId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtStreamingTvProfile.DataTable().destroy();
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
