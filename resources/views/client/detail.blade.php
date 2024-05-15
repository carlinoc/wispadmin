@extends('adminlte::page')

@section('title', 'Detalle del Cliente')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Cliente: {{$client->name}} {{$client->lastName}}</h1>    
        </div>
        <div class="col">
            <a href="{{route('client.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>    
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Planes Contratados</h3>
                        <div class="card-tools">
                            <button type="button" id="btnNewPlan" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Nuevo Plan</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table id="dtPlan" class="table table-striped table-valign-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Instalación</th>
                                    <th>Monto S/</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ultimos Pagos</h3>
                    </div>
                    <div class="card-body p-0">
                        <table id="dtPlanPayment" class="row-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Fecha de Pago</th>
                                    <th>Monto S/</th>
                                    <th>Metodo de Pago</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    @include('client.plan-modal')
@stop

@section('css')
<link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/vendor/admin/main.js"></script>     
<script>
    $(function () {
        $('#dateOrder').datepicker({});
        $('#dateInstall').datepicker({});
    });

    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function() {
        let _planId = $("#planId");
        let _clientId = $("#clientId");
        let _planType = $("#planType");
        let _dateOrder = $("#dateOrder");
        let _dateInstall = $("#dateInstall");
        let _paymentAmount = $("#paymentAmount");
        let _active = $("#active");
                
        let _dtClient = $("#dtPlan");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds=null;

        _paymentAmount.inputFilter(function(value) {return /^-?\d*[.,]?\d*$/.test(value);}, "Ingrese el monto");

        _dateOrder.on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
        _dateInstall.on('changeDate', function(ev){
            $(this).datepicker('hide');
        });

        function fetch() {
            let clientId = $("#clientId").val();
            $.ajax({
                url: "{{ route('client.planList') }}",
                type: "Get",
                data: {clientId:clientId},
                dataType: "json",
                success: function(data) {
                    _ds = data.plans;
                    _dtClient.DataTable({
                        "paging": false,
                        "ordering": false,
                        "info": false,
                        "searching": false,
                        "data": data.plans,
                        "responsive": true,
                        order: [[0, 'desc']],
                        "columns": [
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" style="font-weight: bold;" class="viewPlan" >'+ getPlanType(row.planType) +'</a>';
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    var date = new Date(row.dateInstall);
                                    return dateToYMD(date);
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return row.paymentAmount;
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return (row.active==0?'<small class="badge badge-danger">Inactivo</small>':'<small class="badge badge-success">Activo</small>');
                                }
                            },
                            {
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editClient"><i class="far fa-edit"></i></a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeClient"><i class="far fa-trash-alt"></i></a>';
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#btnNewPlan').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Plan");
            _modal.modal('show');
        });
        
        function clearForm() {
            _planId.val("");
            _planType.val("");
            _dateOrder.val("");
            _dateInstall.val("");
            _paymentAmount.val("");
        }
        
        $('#addPlan').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['planType', 'Seleccione el tipo del plan'],
                ['dateOrder', 'Ingrese la fecha de pedido'],
                ['dateInstall', 'Ingrese la fecha de instalación'],
                ['paymentAmount', 'Ingrese el monto a pagar']
            ];

            if(emptyfy(elements)) {
                let planId = _planId.val();
                var myform = document.getElementById('frmAddPlan');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let route = "{{ route('client.addPlan') }}";
                if(planId!="") {
                    route = "{{ route('client.editPlan') }}";
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
                            //_dtClient.DataTable().destroy();
                            //fetch();
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
        
    });     
</script>
@stop