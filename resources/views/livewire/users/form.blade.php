 @include('common.modalHead')
 <div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label for="">Nombre:</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej. Juan Pérez">
            @error('name') <span class="text-danger er">{{$message}}</span>  @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="">Teléfono:</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej. 976890000" maxlength="9">
            @error('phone') <span class="text-danger er">{{$message}}</span>  @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Email:</label>
            <input type="email"  wire:model.lazy="email" class="form-control" placeholder="email@email.com">
            @error('email') <span class="text-danger er">{{$message}}</span>  @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Contraseña:</label>
            <input type="password"  wire:model.lazy="password" class="form-control" placeholder="******">
            @error('password') <span class="text-danger er">{{$message}}</span>  @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Estado:</label>
            <select  class="form-control" wire:model.lazy="status">
                <option value="Elegir">Elegir...</option>
                <option value="ACTIVE">ACTIVO</option>
                <option value="LOCKED">BLOQUEADO</option>
            </select>
            @error('status') <span class="text-danger er">{{$message}}</span>  @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Asignar perfil:</label>
            <select  class="form-control" wire:model.lazy="profile">
                <option value="Elegir">Elegir...</option>
                @foreach ($roles as $rol)
                
                <option value="{{$rol->name}}">{{$rol->name}}</option>
                @endforeach
            </select>
            @error('profile') <span class="text-danger er">{{$message}}</span>  @enderror
        </div>
    </div>

    <div class="col-sm-12">
        <label for="">Imagen de Perfil:</label>
        <div class="form-group custom-file">
            <div class="form-group custom-file">
                <input type="file" class="form-control custom-file-input" wire:model.lazy="image" accept="image/x-png, image/gif, image/jpeg">
                <label class="custom-file-label">Imágen {{$image}}</label>
            </div>
            @error('image') <span class="text-danger er">{{$message}}</span>  @enderror
        </div>
    </div>
</div>


@include('common.modalfooter')