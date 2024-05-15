<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddStreamingTv">    
        @csrf
        <input type="hidden" id="streamingTvId" name="streamingTvId">
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
                        <label for="name">Streaming</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Streaming">
                    </div>
                    <div class="for-group mt-2">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="https://">
                    </div>
                    <div class="for-group mt-2">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="for-group mt-2">
                        <label for="password">Clave</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Clave">
                    </div>
                    <div class="for-group mt-2">
                        <label for="purchaseprice">Precio S/</label>
                        <input type="text" class="form-control" id="purchaseprice" name="purchaseprice" placeholder="0.00">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addStreamingTv" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>