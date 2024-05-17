@extends('adminlte::page')

@section('title', 'Mantenimiento de Contratos')

@section('content_header')
    <h1>Mantenimiento de Contratos</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newContract" class="btn btn-primary">Nuevo Contrato</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtContract" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Proveedor</th>
                            <th>Servicio</th>
                            <th>F. Orden</th>
                            <th>F. Instalación</th>
                            <th>Ciclo</th>
                            <th>Pago S/</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('contract.add-modal')
@stop

@section('css')
<link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/vendor/admin/main.js"></script>
<script>
    const _token = document.head.querySelector("[name~=csrf-token][content]").content;

    let _contractId = $("#contractId");
    let _providerId = $("#providerId");
    let _serviceProviderId = $("#serviceProviderId");
    let _dateOrder = $("#DateOrder");
    let _dateInstall = $("#DateInstall");
    let _dateInactivity = $("#DateInactivity");
    let _codeOrder = $("#CodeOrder");
    let _codeInstall = $("#CodeInstall");
    let _codeInactivity = $("#CodeInactivity");
    let _paymentAmount = $("#PaymentAmount");
    let _clientId = $("#clientId");

    let _dtContract = $("#dtContract");
    let _modal = $("#addModal");
    let _modalLabel = $("#addModalLabel");
    let _ds=null;

    $(function() {
        $("#DateOrder").datepicker({});
        $("#DateInstall").datepicker({});
        $("#DateInactivity").datepicker({});
    });

    $(document).ready(function() {
    
        _providerId.on("change", function() {
            let providerId = _providerId.val();
            if(providerId != ""){
                fetchServices(providerId);
            }
        });

        _dateOrder.on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
        _dateInstall.on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
        _dateInactivity.on('changeDate', function(ev){
            $(this).datepicker('hide');
        });

        fetchContract();

        $('#newContract').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Contrato");
            _modal.modal('show');
            
            setTimeout(function(){
                _providerId.focus();
            }, 300);
        });

        $('#addContract').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['serviceProviderId', 'Ingrese el servicio'],
                ['DateOrder', 'Ingrese la fecha de pedido'],
                ['CodeOrder', 'Ingrese el código de pedido'],
                ['PaymentAmount', 'Ingrese el el monto a pagar'],
                ['clientId', 'Ingrese el titular']
            ];

            if(emptyfy(elements)) {
                let contractId = _contractId.val();
                
                let route = "{{ route('contract.add') }}";
                if(contractId!="") {
                    route = "{{ route('contract.edit') }}";
                }

                const data = new URLSearchParams();
                const myform = document.getElementById('frmAddContract');
                for (const pair of new FormData(myform)) {
                    data.append(pair[0], pair[1]);
                }

                fetch(route, {
                    method: 'post',
                    body: data,
                })
                .then(response => response.json())
                .then(result => {
                    if(result.status=="success"){
                        _modal.modal('hide');
                        clearForm();
                        fetchContract();
                    }
                })
            }
        });
        
        function clearForm() {
            _contractId.val("");
            _providerId.val("").change();
            _serviceProviderId.html('');
            _dateOrder.val("");
            _dateInstall.val("");
            _dateInactivity.val("");
            _codeOrder.val("");
            _codeInstall.val("");
            _codeInactivity.val("");
            _paymentAmount.val("");
            _clientId.val("").change();
        }
        
    });     

    async function fetchServices(providerId){
        try{
            const response = await fetch("/contract/listservice/" + providerId, {method: 'GET'});
            if(!response.ok){
                throw new Error("Error fetch services")       
            }                    
            const data = await response.json();
            _serviceProviderId.html('')
            for (let service of data.services) {
                var newOption = new Option(service.name, service.id, false, false);
                _serviceProviderId.append(newOption).trigger('change');
            }
        }catch(error){
            console.log(error);
        }
    }

    async function fetchContract(){
        try{
            const response = await fetch("/contract/list", {method: 'GET'});
            if(!response.ok){
                throw new Error("Error fetch services")       
            }                    
            const data = await response.json();
            _ds = data.contracts;
            _dtContract.DataTable().destroy();
            _dtContract.DataTable({
                "data": data.contracts,
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
                            return row.serviceProviderId;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.serviceProviderId;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.DateOrder;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.DateInstall;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.PaymentCycle;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.PaymentAmount;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return '<a href="/contract-detail/'+row.id+'" class="btn btn-sm btn-warning detailContract"><i class="far fa-eye"></i></a> <a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editContract"><i class="far fa-edit"></i></a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeContract"><i class="far fa-trash-alt"></i></a>';
                        }
                    }
                ]
            });
        }catch(error){
            console.log(error);
        }

        _dtContract.on('click', '.editContract', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _contractId.val(id);
                
            }
            
            _modalLabel.text("Editar Contrato");
            _modal.modal('show');
        });

        _dtContract.on('click', '.removeContract', function (e) {
            e.preventDefault();
            let contractId = $(this).data('id');
            
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar la sección?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch("/contract/remove/" + contractId, {
                        method: 'post',
                        body: {contractId : contractId},
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-Token": _token
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.status=="success"){
                            fetchContract();
                        }
                    });
                }
            });
        });
    }
</script>        
@stop