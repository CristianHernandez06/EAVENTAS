<div class="row sales layout-top-spacing">
<div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}}</b>
                </h4>
            </div>

            <div class="widget-content">

                <div class="form-inline">
                    <!--select roles-->
                    <div class="form-group mr-5">

                        <select wire:model ="role" class="form-control">

                                <option value="Elegir" selected>== Selecciona el Rol ==</option>

                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach

                        </select>

                    </div>

                    <!--buttons-->

                    <!--buttons sincronizar todos los permisos a un rol-->
                    <button wire:click.prevent="SyncAll()" class="btn btn-info mbmobile inblock mr-5">Sincronizar Todos</button>

                    <!--buttons revocar todos los permisos a un rol-->
                    <button onclick="Revocar()" class="btn btn-danger mbmobile  mr-5">Revocar Todos</button>

                </div>


                <div class="row mt-3">

                    <div class="col-sm-12">

                    <div class="table-responsive">
                    {{$permisos}}
                         <table class="table table-bordered table-striped mt-1">
                          <thead class="text-white" style="background: #000000">
                            <tr>
                                <th class="table-th text-white text-center">ID</th>
                                <th class="table-th text-white text-center">PERMISO</th>
                                <th class="table-th text-white text-center">ROLES CON EL PERMISO</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($permisos as $p)

                            <tr>
                                <td><h6 class="text-center">{{$p->id}}</h6></td>
                                <td class="text-center">

                                <!--creamos una clase check-->
                                <div class="n-check">
                                    <label class="new-control new-checkbox checkbox-primary">
                                        <input type="checkbox"
                                        wire:change="SyncPermiso($('#p' + {{$p ->id}}).is(':checked'), '{{$p->name}}')"
                                        id="p{{ $p->id }}"
                                        value="{{$p->id}}"
                                        class="new-control-input"
                                        {{$p->checked ? 'checked' : ''}}>
                                        <span class="new-control-indicator"></span>
                                        <h6>{{$p->name}}</h6>
                                    </label>
                                </div>

                                </td>
                                <td class="text-center">
                                    <h6>{{ App\Models\User::permission($p->name)->count()}}</h6>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$permisos->links()}}

                    </div>

                </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){

        window.livewire.on('test', Msg => {
          console.log(Msg)

      })


      window.livewire.on('sync-error', Msg => {
          console.log(Msg)
          notify(Msg)
      })

      window.livewire.on('permi', Msg => {
        console.log(Msg)
          notify(Msg)
      })

      window.livewire.on('SyncAll', Msg => {
        console.log(Msg)
          notify(Msg)
      })

      window.livewire.on('removeall', Msg => {
        notify(Msg)
      })


    });

    function Revocar()
{
      Swal({
        title: 'CONFIRMAR',
        text:'¿CONFIRMAS REVOCAR TODOS LOS PERMISOS?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText:'Cerrar',
        cancelButtonColor: '#fff',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#3B3F5C',
    }).then(function(result){
        if(result.isConfirmed)
        {
            swal.fire(
                'Revocado/s',
                'El/los registros han sido revocados',
                'succes'
            )

        }
        window.livewire.emit('revokeall')
            swal.close()
    })
}


</script>
