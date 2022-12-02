<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-info" data-toggle="modal"
                            data-target="#theModal">
                            <i class="fas fa-plus"></i> Agregar
                        </a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table mt-1 table-bordered table-striped">
                        <thead class="text-white" style="background: #000000">
                            <tr>
                                <th class="text-white table-th">ID</th>
                                <th class="text-center text-white table-th">DESCRIPCIÓN</th>
                                <th class="text-center text-white table-th">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)


                                <tr>
                                    <td>
                                        <h6>{{ $permiso->id }}</h6>
                                    </td>
                                    <td class="text-center">
                                        {{ $permiso->name }}
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $permiso->id }})"
                                            class="btn btn-info mtmobile" title="Editar registro"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="confirm('{{ $permiso->id }}')"
                                            class="btn btn-danger mtmobile" title="Eliminar registro"><i
                                                class="fas fa-trash"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$permisos->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.permisos.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('permiso-added', Msg => {
            $("#theModal").modal('hide');
            notify(Msg);
        })
        window.livewire.on('permiso-updated', Msg => {
            $("#theModal").modal('hide');
            notify(Msg);
        })
        window.livewire.on('permiso-deleted', Msg => {
            notify(Msg);
        })
        window.livewire.on('permiso-exists', Msg => {
            notify(Msg);
        })
        window.livewire.on('permiso-error', Msg => {
            notify(Msg);
        })
        window.livewire.on('hide-modal', Msg => {
            $("#theModal").modal('hide');
            notify(Msg);
        })
        window.livewire.on('show-modal', Msg => {
            $("#theModal").modal('show');

        })

    });

    function confirm(id) {
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
