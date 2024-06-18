<!-- Modal -->
<div class="modal fade" id="modalModem" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddModem">    
        @csrf
        <input type="hidden" id="contractId" name="contractId" value="{{ $contract->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Modem</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Rayado</label>
                                <input type="text" class="form-control" id="MarkCode0" name="MarkCode" placeholder="Ingresar el Rayado" required>
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>MAC</label>
                                <input type="text" class="form-control" id="MAC" name="MAC" placeholder="00:00:00:00:00:00" required>
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Url default de conexión</label>
                                <input type="text" class="form-control" id="DefaultUrl" name="DefaultUrl" placeholder="http://" required>
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Nombre de Wifi</label>
                                <input type="text" class="form-control" id="DefaultWifiName" name="DefaultWifiName" placeholder="Ingrese el usuario de conexión" required>
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Contraseña de Wifi</label>
                                <input type="text" class="form-control" id="DefaultWifiPassword" name="DefaultWifiPassword" placeholder="Ingrese la contraseña de conexión" required>
                            </div>            
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="ConnectionType">Tipo de conexión</label>
                                <select class="form-control" name="ConnectionType" id="ConnectionType">
                                    <option value=""> - Seleccione - </option>
                                    <option value="1">HFC</option>
                                    <option value="2">Fibra</option>
                                    <option value="3">Antena</option>
                                </select>
                            </div>            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="ConnectionType">Modelo</label>
                                <x-adminlte-select2 id="modemTypeId" name="modemTypeId" label-class="text-lightblue" data-placeholder="Seleccione un modelo">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-info">
                                            <i class="fas fa-mouse-pointer"></i>
                                        </div>
                                    </x-slot>
                                    <option value=""></option>
                                    @foreach($modemTypes as $modemType)
                                        <option value="{{$modemType->id}}">{{$modemType->name}}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>            
                        </div>
                        <div class="col-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addModem" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>