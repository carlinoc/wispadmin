<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddPlan">    
        @csrf
        <input type="hidden" id="planId" name="planId">
        <input type="hidden" id="clientId" name="clientId" value="{{$client->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Plan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="pt-2" for="planType">Tipo de Plan:</label>
                        </div>
                        <div class="col">
                            <select class="form-control" name="planType" id="planType">
                                <option value=""> - Seleccione - </option>
                                <option value="1">Simple</option>
                                <option value="2">Duo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label class="pt-2" for="dateOrder">Fecha de pedido:</label>
                        </div>
                        <div class="col">
                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control" id="dateOrder" name="dateOrder" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label class="pt-2" for="dateInstall">Fecha de instalación:</label>
                        </div>
                        <div class="col">
                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control" id="dateInstall" name="dateInstall" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label class="pt-2" for="paymentAmount">Monto a pagar S/:</label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="paymentAmount" name="paymentAmount" placeholder="0.00">
                        </div>
                    </div>
                    <div class="for-group mt-2">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                            <label class="custom-control-label" for="active">Plan activo. &nbsp;&nbsp;-&nbsp;&nbsp; Ciclo de pago cada 30 de cada mes.</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addPlan" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>