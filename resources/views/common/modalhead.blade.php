<div wire:ignore.self class="modal fade" id="themodal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #000000">
        <h5 class="modal-title text-white">
        <b>{{$componentName}} | {{$selected_id > 0 ? 'Editar':'Crear'}}</b>
        </h5>
        <h6 class="text-center text-warning" wire:loading>Por Favor Espere</h6>
      </div>
      <div class="modal-body">
