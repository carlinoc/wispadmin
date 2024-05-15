<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddZone">    
        @csrf
        <input type="hidden" id="zoneId" name="zoneId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nueva Zona</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la Zona">
                    </div>
                    <div class="for-group">
                        <label for="nickName">Alias</label>
                        <input type="text" class="form-control" id="nickName" name="nickName" placeholder="Alias de la Zona">
                    </div>
                    <div class="form-group">
                        <label>Distrito:</label>
                        <select class="form-control" name="district" id="district">
                            <option value="">Ninguno</option>
                            <option value="CU">Cusco</option>
                            <option value="WA">Wanchaq</option>
                            <option value="SS">San Sebastian</option>
                            <option value="SJ">San Jeronimo</option>
                        </select>
                    </div>    
                </div>
                <div class="modal-footer">
                    <button id="addZone" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>