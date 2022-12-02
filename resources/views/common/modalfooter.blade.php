</div>
      <div class="modal-footer">
        <button type="button" wire:click.prevent="ResetUI()"class="btn btn-info close-btn text-info" data-dismiss="modal">Cerrar</button>
        @if($selected_id < 1)
        <button type="button" wire:click.prevent="Store()"class="btn btn-info close-modal">Guardar</button>
        @else
        <button type="button" wire:click.prevent="Update()"class="btn btn-info close-modal">Actualizar</button>
        @endif
      </div>
    </div>
  </div>
</div>
