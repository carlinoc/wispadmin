<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddPaymentMethod">    
        @csrf
        <input type="hidden" id="paymentMethodId" name="paymentMethodId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Método de pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del Método de pago">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripción</label>
                        <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripción"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="addPaymentMethod" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>