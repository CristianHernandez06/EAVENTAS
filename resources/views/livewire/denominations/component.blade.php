<div class="row sales layout-top-spacing">


    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <!--Encabezado-->
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-info" data-toggle="modal"
                            data-target="#themodal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')
            <!--Contenido de la targeta (cardbody)-->
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table mt-1 table-bordered striped">


                        <thead class="text-white" style="background: #000000">

                            <tr>
                                <th class="text-center text-white table-th">DESCRIPCIÓN</th>
                                <th class="text-center text-white table-th">VALOR</th>
                                <th class="text-center text-white table-th">IMAGEN</th>
                                <th class="text-center text-white table-th">ACCIÓN</th>
                            </tr>

                        </thead>

                        <tbody>
                            @foreach ($data as $coin)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $coin->type }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>${{number_format($coin->value) }}</h6>
                                    </td>
                                    <td class="text-center">
                                        @if ($coin->image != null)
                                            <span>
                                                <img src="{{ asset('storage/denomination/' . $coin->image) }}"
                                                    height="70" width="80" class="rounded" alt="no-image">
                                            </span>
                                        @else
                                            <img src="{{ asset('images/noimage.jpg') }}" height="70" width="80"
                                                class="rounded" alt="no-image">

                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $coin->id }})"
                                            class="btn btn-info mtmobile" tittle="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" class="btn btn-danger" tittle="Delete"
                                            onclick="confirm('{{ $coin->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </a>

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

    @include('livewire.denominations.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('denomination-added', msg => {
            $('#themodal').modal('hide');
        });

        //listen row-updated event//
        window.livewire.on('denomination-updated', msg => {
            $('#themodal').modal('hide');
        });

        window.livewire.on('denomination-delete', msg => {

        });
        window.livewire.on('hide-modal', msg => {
            $('#themodal').modal('hide')
        });

        window.livewire.on('show-modal', msg => {
            $('#themodal').modal('show')
        });


        $('#themodal').on('hiden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });

    });




    function confirm(id, products) {


        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS QUE DESEAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#3B3F5C',
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close()
            }
        })
    }
</script>
