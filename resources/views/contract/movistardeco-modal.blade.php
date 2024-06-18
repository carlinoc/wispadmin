<!-- Modal -->
<div class="modal fade" id="modalMovistarDeco" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddMovistarDeco">    
        @csrf
        <input type="hidden" id="serviceProviderId" name="serviceProviderId" value="{{ $contract->serviceProviderId }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo MovistarDeco</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>CASID</label>
                                <input type="text" class="form-control" id="CASID" name="CASID" placeholder="Ingresar CASID" required>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Numero de la tarjeta</label>
                                <input type="text" class="form-control" id="CardNumber" name="CardNumber" placeholder="Ingresar CardNumber" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Rayado</label>
                                <input type="text" class="form-control" id="MarkCode" name="MarkCode" placeholder="Ingresar MarkCode" required>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Tipo de Deco</label>
                                <select class="form-control" name="DecoType" id="DecoType">
                                    <option value="1">CATV (De poste)</option>
                                    <option value="2">DTH (De antena)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addMovistarDeco" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>