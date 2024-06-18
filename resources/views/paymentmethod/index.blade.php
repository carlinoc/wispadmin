@extends('adminlte::page')

@section('title', 'Mantenimiento de Métodos de pago')

@section('content_header')
    <h1>Mantenimiento de Métodos de pago</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newPaymentMethod" class="btn btn-primary">Nuevo Método de Pago</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtPaymentMethod" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('paymentmethod.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    const _token = document.head.querySelector("[name~=csrf-token][content]").content;

    let _paymentMethodId = $("#paymentMethodId");
    let _name = $("#name");
    let _description = $("#description");
    
    let _dtPaymentMethod = $("#dtPaymentMethod");
    let _modal = $("#addModal");
    let _modalLabel = $("#addModalLabel");
    let _ds=null;   
    
    $(document).ready(function() {
            
        fetchPaymentMethod();

        $('#newPaymentMethod').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Método de pago");
            _modal.modal('show');
            
            setTimeout(function(){
                _name.focus();
            }, 300);
        });

        $('#addPaymentMethod').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre']
            ];

            if(emptyfy(elements)) {
                let paymentMethodId = _paymentMethodId.val();
                
                let route = "{{ route('paymentmethod.add') }}";
                if(paymentMethodId!="") {
                    route = "{{ route('paymentmethod.edit') }}";
                }

                let data = getFormParams('frmAddPaymentMethod');
                fetch(route, {
                    method: 'post',
                    body: data,
                })
                .then(response => response.json())
                .then(result => {
                    if(result.status=="success"){
                        _modal.modal('hide');
                        clearForm();
                        fetchPaymentMethod();
                    }
                })
            }
        });        
        
        _dtPaymentMethod.on('click', '.editPaymentMethod', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _paymentMethodId.val(id);
                _name.val(name);
                _description.val(description);
            }
            
            _modalLabel.text("Editar Método de pago");
            _modal.modal('show');
        });

        _dtPaymentMethod.on('click', '.removePaymentMethod', function (e) {
            e.preventDefault();
            let paymentMethodId = $(this).data('id');
            
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el Método de pago?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch("/paymentmethod/remove/" + paymentMethodId, {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            "X-CSRF-Token": _token
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.status=="success"){
                            fetchPaymentMethod();
                        }
                    });
                }
            });
        });
    });     

    async function fetchPaymentMethod() {
        const response = await fetch("/paymentmethod/list", {method: 'GET'});
        if(!response.ok){
            throw new Error("Error fetch services")       
        }                    
        const data = await response.json();
        _ds = data.paymentMethods;
        _dtPaymentMethod.DataTable().destroy();
        _dtPaymentMethod.DataTable({
            "data": data.paymentMethods,
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
                        return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editPaymentMethod"><i class="far fa-edit"></i></a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removePaymentMethod"><i class="far fa-trash-alt"></i></a>';
                    }
                }
            ]
        });
    }

    function clearForm() {
        _paymentMethodId.val('');
        _name.val('');
        _description.val('');
    }
</script>        
@stop