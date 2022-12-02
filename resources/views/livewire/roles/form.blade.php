<div wire:ignore.self class="modal fade" tabindex="-1" id="theModal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background: #000000">
          <h5 class="modal-title text-white">
              <b>{{$componentName}}</b> | {{$selected_id > 0 ? 'EDITAR' : 'CREAR'}}
          </h5>
         <h6 class="text-center text-warning" wire:loading>
             POR FAVOR ESPERE...
         </h6>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-edit"></i>
                            </span>
                        </div>
                        <input type="text" wire:model.lazy="roleName" class="form-control" placeholder="ej. Vendedor" maxlength="255">
                    </div>
                    @error('roleName')<span class="text-danger er">{{$message}}</span>@enderror
                </div>
            </div>


        </div>
        <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-light text-primary" data-dismiss="modal">CERRAR</button>
            @if ($selected_id < 1)
                <button type="button" wire:click.prevent="CreateRole()" class="btn btn-info close-modal" >GUARDAR</button>
            @else
                <button type="button" wire:click.prevent="UpdateRole()" class="btn btn-info close-modal" >ACTUALIZAR</button>
            @endif
        </div>
    </div>
</div>
</div>
