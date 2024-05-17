<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddSwitcher">
        @csrf
        <input type="hidden" id="switcherId" name="switcherId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo switcher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="serie">Serie</label>
                        <input type="text" class="form-control" id="serie" name="serie" placeholder="serie">
                    </div>
                    <div class="for-group">
                        <label for="numberOfPorts">Nro puertos</label>
                        <input type="text" class="form-control" id="numberOfPorts" name="numberOfPorts" placeholder="numberOfPorts">
                    </div>
                    <div class="for-group">
                        <label for="state">Estado</label>
                        <select class="form-control" name="state" id="state">
                            <option value=""> - Seleccione - </option>
                            <option value="1">Nuevo</option>
                            <option value="2">Usado</option>
                            <option value="3">Malogrado</option>
                        </select>
                    </div>
                    <div class="for-group">
                        <label for="description">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="description">
                    </div>
                    <div class="form-group mt-3">
                        <x-adminlte-select2 id="brandNameId" name="brandNameId" label-class="text-lightblue" data-placeholder="Seleccione una marca">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </x-slot>
                            <option value=""></option>
                            @foreach($brandNames as $brandName)
                                <option value="{{$brandName->id}}">{{$brandName->name}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addSwitcher" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>
