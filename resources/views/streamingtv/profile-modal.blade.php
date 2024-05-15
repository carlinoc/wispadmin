<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddStreamingTvProfile">    
        @csrf
        <input type="hidden" id="streamingTvProfileId" name="streamingTvProfileId">
        <input type="hidden" id="streamingTvId" name="streamingTvId" value="{{$streamingtv->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Streaming</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="profile">Perfil</label>
                        <input type="text" class="form-control" id="profile" name="profile" placeholder="Perfil">
                    </div>
                    <div class="for-group mt-2">
                        <label for="accessCode">PIN</label>
                        <input type="text" class="form-control" id="accessCode" name="accessCode" placeholder="PIN">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addStreamingTvProfile" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>