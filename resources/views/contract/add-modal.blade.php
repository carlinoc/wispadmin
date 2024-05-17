<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddContract">    
        @csrf
        <input type="hidden" id="contractId" name="contractId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Contrato</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Proveedor</label>
                                <x-adminlte-select2 id="providerId" name="providerId" label-class="text-lightblue" data-placeholder="Seleccione una proveedor">
                                    <option value=""></option>
                                    @foreach($providers as $provider)
                                        <option value="{{$provider->id}}">{{$provider->name}}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Servicio</label>
                                <x-adminlte-select2 id="serviceProviderId" name="serviceProviderId" label-class="text-lightblue" data-placeholder="Seleccione una servicio">
                                    <option value=""></option>
                                </x-adminlte-select2>
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Fecha de Pedido</label>
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control" id="DateOrder" name="DateOrder" placeholder="dd-mm-yyyy">
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Código de Pedido</label>
                                <input type="text" class="form-control" id="CodeOrder" name="CodeOrder" placeholder="">
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Fecha de Instalación</label>
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control" id="DateInstall" name="DateInstall" placeholder="dd-mm-yyyy">
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Código de Instalación</label>
                                <input type="text" class="form-control" id="CodeInstall" name="CodeInstall" placeholder="">
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Fecha de Inactividad</label>
                                <input type="text" data-date-format="dd-mm-yyyy" class="form-control" id="DateInactivity" name="DateInactivity" placeholder="dd-mm-yyyy">
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Código de Inactividad</label>
                                <input type="text" class="form-control" id="CodeInactivity" name="CodeInactivity" placeholder="">
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="model">Día de pago:</label>
                                <select class="form-control" name="PaymentCycle" id="PaymentCycle" required>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Monto a pagar S/</label>
                                <input type="text" class="form-control" id="PaymentAmount" name="PaymentAmount" value="0.00" placeholder="0.00">
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Titular</label>
                                <x-adminlte-select2 id="clientId" name="clientId" label-class="text-lightblue" data-placeholder="Seleccione un Titular">
                                    <option value=""></option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}} {{$client->lastName}}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                
                            </div>            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addContract" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>