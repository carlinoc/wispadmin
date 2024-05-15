<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddClient">    
        @csrf
        <input type="hidden" id="clientId" name="clientId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del cliente">
                    </div>
                    <div class="for-group mt-2">
                        <label for="lastName">Apellidos</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Apellido del cliente">
                    </div>
                    <div class="for-group mt-2">
                        <label for="DNI">DNI</label>
                        <input type="text" class="form-control" id="DNI" name="DNI" placeholder="DNI del cliente">
                    </div>
                    <div class="for-group mt-2">
                        <label for="phone">Telefono</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefono del Cliente">
                    </div>
                    <div class="for-group mt-2">
                        <label for="adress">Dirección</label>
                        <input type="text" class="form-control" id="adress" name="adress" placeholder="Dirección del cliente">
                    </div>
                    <div class="for-group mt-2">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email del cliente">
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
                </div>
                <div class="modal-footer">
                    <button id="addClient" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>