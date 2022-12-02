<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-info" data-toggle="modal" data-target="#themodal">
                        <i class="bi bi-plus-lg"></i> Agregar
                        </a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #000000">
                            <tr>
                                <th class="table-th text-white">USUARIO</th>
                                <th class="table-th text-white text-center">TELEFONO</th>
                                <th class="table-th text-white text-center">EMAIL</th>
                                <th class="table-th text-white text-center">PERFIL</th>
                                <th class="table-th text-white text-center">STATUS</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $r)
                            <tr>
                                <td><h6>{{$r->name}}</h6></td>
                                <td><h6 class="text-center">{{$r->phone}}</h6></td>
                                <td><h6 class="text-center">{{$r->email}}</h6></td>
                                <td class="text-center">
                                    <span class="badge {{$r->status == 'ACTIVE' ? 'badge-success' : 'badge-danger'}}">{{$r->profile}}</span>
                                  </td>
                                <td class="text-center">
                                    <span class="badge {{$r->status == 'ACTIVE' ? 'badge-success' : 'badge-danger'}} text-uppercase">{{$r->status == 'ACTIVE' ? 'ACTIVO' : 'BLOQUEADO'}}</span>

                                </td>
                                <td class="text-center">
                                    @if($r->image != null)
                                    <img src="{{asset('storage/users/' . $r->image )}}" height="70" width="80" class="rounded" alt="imagen" >
                                    @else
                                    <img src="{{ asset('images/noimage.jpg') }}"
                                    height="70" width="80" class="rounded" alt="no-image">
                                    @endif
                                    </td>
                                <td class="text-center" style="width: 150px">
                                    <a href="javascript:void(0)"  wire:click="edit({{ $r->id }})" class="btn btn-info mtmobile" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $r->id }}')"  class="btn btn-danger mtmobile" title="Eliminar"><i class="fas fa-trash"></i></a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.users.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('user-added', Msg=>{
             $("#themodal").modal('hide');
             notify(Msg)
        });
        window.livewire.on('user-updated', Msg=>{
             $("#themodal").modal('hide');
             notify(Msg)
        });
        window.livewire.on('user-deleted', Msg=>{
            notify(Msg)
        });
        window.livewire.on('hide-modal', Msg=>{
             $("#themodal").modal('hide');
        });
        window.livewire.on('show-modal', Msg=>{
             $("#themodal").modal('show');
        });
        window.livewire.on('user-withsales', Msg=>{
            notify(Msg)
        });
    });

  function Confirm(id)
{

    swal({
        title: 'CONFIRMAR',
        text:'¿CONFIRMAS QUE DESEAS ELIMINAR EL REGISTRO?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText:'Cerrar',
        cancelButtonColor: '#fff',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#3B3F5C',
    }).then(function(result){
        if(result.value)
        {
            window.livewire.emit('deleterow', id)
            swal.close()
        }
    })
}
</script>
