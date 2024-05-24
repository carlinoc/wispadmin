@extends('adminlte::page')

@section('title', 'Detalle del contrato')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>{{ $contract->provider }}: {{ $contract->service }}</h1>
        </div>
        <div class="col">
            <a href="{{ route('contract.index') }}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Fecha de Instalación</strong>
                    <p class="text-muted">
                        {{ $contract->DateInstall }}, código: {{ $contract->CodeInstall }}
                    </p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Día de Pago</strong>
                    <p class="text-muted">{{ $contract->PaymentCycle }} de cada mes.</p>
                    <hr>
                    <strong><i class="fas fa-pencil-alt mr-1"></i> Monto S/</strong>
                    <p class="text-muted">
                        {{ $contract->PaymentAmount }}
                    </p>
                    <hr>
                    <strong><i class="far fa-file-alt mr-1"></i> Titular</strong>
                    <p class="text-muted">
                        {{ $contract->ClientName }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div id="cardModem" class="card card-primary">
                <div class="card-header">
                    <h3 id="titleModem" class="card-title">Modems:</h3>
                    <div class="card-tools">
                        <a href="#" id="newModem" class="btn-sm btn-dark">+ Nuevo</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table id="dtModems" class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>MAC</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card card-info collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Decos</h3>
                    <div class="card-tools">
                        <a href="#" id="newDeco" class="btn-sm btn-dark">+ Nuevo</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Functional-requirements.docx</td>
                                <td>49.8005 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>UAT.pdf</td>
                                <td>28.4883 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Ultimos Pagos</h3>
                    <div class="card-tools">
                        <a href="#" id="newPayment" class="btn-sm btn-dark">+ Nuevo</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Functional-requirements.docx</td>
                                <td>49.8005 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>UAT.pdf</td>
                                <td>28.4883 kb</td>
                                <td class="text-right py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('contract.modem-modal')
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
    <script src="/vendor/admin/main.js"></script>
    <script>
        let _token = document.head.querySelector("[name~=csrf-token][content]").content;

        let _cardModem = $("#cardModem");
        let _name = $("#name");
        let _mac = $("#MAC");
        let _defaultUrl = $("#DefaultUrl");
        let _defaultWifiName = $("#DefaultWifiName");
        let _defaultWifiPassword = $("#DefaultWifiPassword");
        let _connectionType = $("#ConnectionType");
        let _modemTypeId = $("#modemTypeId");
        let _titleModem = $("#titleModem");
        
        let _dtModems = $("#dtModems");
        let _modal = $("#addModal");
        let _modalLabel = $("#addModalLabel");
        let _ds = null;

        fetchModems();

        _cardModem.CardWidget('toggle');

        $('#newModem').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Modem");
            _modal.modal('show');
            
            setTimeout(function(){
                _name.focus();
            }, 300);
        });

        $('#newDeco').on('click', function(e) {
            e.preventDefault();
            
        });

        $('#addModem').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre del modem'],
                ['MAC', 'Ingrese la MAC'],
                ['ConnectionType', 'Ingrese el tipo de connexión'],
                ['modemTypeId', 'Ingrese el tipo de modem']
            ];

            if(emptyfy(elements)) {
                let route = "{{ route('contract.addmodem') }}";
                let data = getFormParams('frmAddModem');

                fetch(route, {
                    method: 'post',
                    body: data,
                })
                .then(response => response.json())
                .then(result => {
                    if(result.status=="success"){
                        _modal.modal('hide');
                        clearForm();
                        //_cardModem.CardWidget('toggle');
                        fetchModems();
                    }
                    if(result.status=="error"){
                        showErrorMsg(result.message);
                    }
                })
            }
        });

        _dtModems.on('click', '.removeModem', function (e) {
            e.preventDefault();
            let modemId = $(this).data('id');
            
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el Modem?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch("/contract/removemodem/" + modemId, {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-Token": _token
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.status=="success"){
                            fetchModems();
                        }
                    });
                }
            });
        });

        async function fetchModems(){
            let _id = {{ $contract->serviceProviderId }};
            const response = await fetch("/contract/listmodem/" + _id, {method: 'GET'});
            if(!response.ok){
                throw new Error("Error fetch list modem")       
            }                    
            const data = await response.json();
            _titleModem.html('Modems: ' + data.modems.length);
            _dtModems.DataTable().destroy();
            _dtModems.DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false,
                "data": data.modems,
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
                            return row.MAC;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return '<a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeModem"><i class="fas fa-trash"></a>';
                        }
                    }
                ]
            });
        }

        function clearForm() {
            _name.val("");
            _mac.val("");
            _defaultUrl.val("");
            _defaultWifiName.val("");
            _defaultWifiPassword.val("");
            _connectionType.val("");
            _modemTypeId.val("").change();
        }
    </script>
@stop
