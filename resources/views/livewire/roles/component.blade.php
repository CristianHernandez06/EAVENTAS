<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-info" data-toggle="modal" data-target="#theModal">
                        <i class="fas fa-plus"></i> Agregar
                        </a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background:#000000;">
                            <tr>
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white text-center">DESCRIPCIÓN</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)


                            <tr>
                                <td><h6>{{$role->id}}</h6></td>
                                <td class="text-center">
                                    {{$role->name}}
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)"  wire:click="Edit({{$role->id}})" class="btn btn-info mtmobile" title="Editar registro"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="confirm({{$role->id}})"  class="btn btn-danger mtmobile" title="Eliminar registro"><i class="fas fa-trash"></i></a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$roles->links()}}
                </div>
            </div>
        </div>
    </div>
@include('livewire.roles.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('role-added', Msg =>{
            $("#theModal").modal('hide');
            notify(Msg);
        })
        window.livewire.on('role-updated', Msg =>{
            $("#theModal").modal('hide');
            notify(Msg);
        })
        window.livewire.on('role-deleted', Msg =>{
            notify(Msg);
        })
        window.livewire.on('role-exists', Msg =>{
            notify(Msg);
        })
        window.livewire.on('role-error', Msg =>{
            notify(Msg);
        })
        window.livewire.on('hide-modal', Msg =>{
            $("#theModal").modal('hide');
            notify(Msg);
        })
        window.livewire.on('show-modal', Msg =>{
            $("#theModal").modal('show');

        })

    });

    function confirm(id)
    {
         Swal.fire({
          title: 'CONFIRMAR',
          text: "¿CONFIRMAS ELIMINAR EL REGISTRO?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Aceptar',
          confirmButtonColor: '#3B3F5C',
          cancelButtonText: 'Cerrar',
          cancelButtonColor: '#ADADB0',

        }).then((result) => {
          if (result.value) {
            window.livewire.emit('deleteRow', id)
            swal.fire(
                'El Registro ha sido eliminado satisfactoriamente'

            )
          }
        })
    }
</script>
