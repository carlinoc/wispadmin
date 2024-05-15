<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddProvider">    
        @csrf
        <input type="hidden" id="providerId" name="providerId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Proveedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del proveedor">
                    </div>
                    <div class="for-group mt-2">
                        <label for="phone">Telefono</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefono del proveedor">
                    </div>
                    <div class="for-group mt-2">
                        <label for="contactName">Contacto</label>
                        <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Nombre de contacto">
                    </div>
                    <div class="for-group mt-2">
                        <label for="contactPhone">Contacto Teléfono</label>
                        <input type="text" class="form-control" id="contactPhone" name="contactPhone" placeholder="Teléfono del contacto">
                    </div>
                    <div class="form-group mt-3">
                        <x-adminlte-select2 id="zoneId" name="zoneId" label-class="text-lightblue" data-placeholder="Seleccione una zona">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </x-slot>
                            <option value=""></option>
                            @foreach($zones as $zone)
                                <option value="{{$zone->id}}">{{$zone->nickName}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripción</label>
                        <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripción"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addProvider" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>