@extends('adminlte::page')

@section('title', 'Mantenimiento de StreamingTv')

@section('content_header')
    <h1>Mantenimiento de StreamingTv</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newStreamingTv" class="btn btn-primary">Crear Nuevo Streaming</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtStreamingTv" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Streaming</th>
                            <th>URL</th>
                            <th>Email</th>
                            <th>Clave</th>
                            <th>Precio</th>
                            <th>Perfiles</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('streamingtv.add-modal')

@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _streamingTvId = $("#streamingTvId");
        let _name = $("#name");
        let _url = $("#url");
        let _email = $("#email");
        let _password = $("#password");
        let _purchaseprice = $("#purchaseprice");
        let _dtStreamingTv = $("#dtStreamingTv");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        _purchaseprice.inputFilter(function(value) {return /^-?\d*[.,]?\d*$/.test(value);}, "Ingrese el monto");

        function fetch() {
            $.ajax({
                url: "{{ route('streamingtv.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    _ds = data.streamingTvs;
                    _dtStreamingTv.DataTable({
                        "data": data.streamingTvs,
                        "responsive": true,
                        order: [[0, 'desc']],
                        "columns": [
                            {
                                "render": function(data, type, row, meta) {
                                    return row.id;
                                }
                            },
                            {"render": function(data, type, row, meta) {return row.name;}},
                            {"render": function(data, type, row, meta) {return row.url;}},
                            {"render": function(data, type, row, meta) {return row.email;}},
                            {"render": function(data, type, row, meta) {return row.password;}},
                            {"render": function(data, type, row, meta) {return row.purchaseprice;}},
                            {"render": function(data, type, row, meta) {return row.profiles;}},
                                                        
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="/streamingtv-detail/'+row.id+'" class="btn btn-sm btn-warning detailClient"><i class="far fa-eye"></i></a> <a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editStreamingTv"><i class="far fa-edit"></i></a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeStreamingTv"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newStreamingTv').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Streaming");
            _modal.modal('show');

            setTimeout(function(){
                _name.focus();
            }, 300);
        });

        $('#addStreamingTv').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre'],
                ['url', 'Ingrese la Url'],
                ['email', 'Ingrese el email'],
                ['password', 'Ingrese el password'],
                ['purchaseprice', 'Ingrese el precio'],
            ];

            if(emptyfy(elements)) {
                let streamingTvId = _streamingTvId.val();
                var myform = document.getElementById('frmAddStreamingTv');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let route = "{{ route('streamingtv.add') }}";
                if(streamingTvId!="") {
                    route = "{{ route('streamingtv.edit') }}";
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
                            _dtStreamingTv.DataTable().destroy();
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

        _dtStreamingTv.on('click', '.editStreamingTv', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _streamingTvId.val(id);
                _name.val(name);
                _url.val(url);
                _email.val(email);
                _password.val(password);
                _purchaseprice.val(purchaseprice);
            }
            _modalLabel.text("Editar Streaming");
            _modal.modal('show');
        });    


        _dtStreamingTv.on('click', '.removeStreamingTv', function (e) {
            e.preventDefault();
            let streamingTvId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar Streaming?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('streamingtv.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            streamingTvId:streamingTvId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                _dtStreamingTv.DataTable().destroy();
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
            _streamingTvId.val("");
            _name.val("");
            _url.val("");
            _email.val("");
            _password.val("");
            _purchaseprice.val("");
        }
    });     
</script>      
@stop
