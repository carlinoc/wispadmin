<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddServiceProvider">    
        @csrf
        <input type="hidden" id="serviceProviderId" name="serviceProviderId">
        <input type="hidden" id="providerId" name="providerId" value="{{$provider->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Servicio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Servicio">
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="InternetService" name="InternetService">
                                <label class="custom-control-label" for="InternetService">Internet</label>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="CableService" name="CableService">
                                <label class="custom-control-label" for="CableService">Cable</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripción</label>
                        <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripción"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addServiceProvider" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>