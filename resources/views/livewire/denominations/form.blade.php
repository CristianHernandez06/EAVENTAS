@include('common.modalhead')

<div class="row">

<div class="col-sm-12 col-md-6">
    <div class="form-group">
        <label>Tipo:</label>
        <select wire:model="type" id="type" class="form-control">
            <option value="Seleccionar">Seleccionar</option>
            <option value="BILLETE">Billete</option>
            <option value="MONEDA">Moneda</option>
            <option value="OTRO">Otro</option>
        </select>
        @error('type') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
</div>

    <div class="col-sm-12 col-md-6">
        <label>Valor:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
             </div>
            <input type="number" wire:model.lazy="value" class="form-control" placeholder="Ej:100" maxlength="25">
         </div>
          @error('value') <span class="text-danger er">{{$message}}</span>@enderror
    </div>
    <!--Input de imagen-->
    <div class="col-sm-12 ">
    <label>Imagen de la moneda:</label>
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image" accept="image/x-png, image/gif,image/jpeg">
            <label class="custom-file-label">Imagen {{$image}}</label>
            @error('image') <span class="text-danger er">{{$message}}</span>@enderror

        </div>

    </div>

</div>

@include('common.modalfooter')
