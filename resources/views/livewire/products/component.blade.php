<div class="row sales layout-top-spacing">


    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <!--Encabezado-->
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <!--VALIDACION CREAR PRODUCTO-->
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-info" data-toggle="modal"
                            data-target="#themodal">Agregar</a>
                    </li>

                </ul>
            </div>
            <!--VALIDACION BUSCAR PRODUCTO-->
            @include('common.searchbox')

            <!--Contenido de la targeta (cardbody)-->
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table mt-1 table-bordered striped">


                        <thead class="text-white" style="background:#000000">

                            <tr>
                                <th class="text-center text-white table-th">DESCRIPCIÓN</th>
                                <th class="text-center text-white table-th">CÓDIGO DE BARRA</th>
                                <th class="text-center text-white table-th">CATEGORÍA</th>
                                <th class="text-center text-white table-th">COSTO</th>
                                <th class="text-center text-white table-th">PRECIO</th>
                                <th class="text-center text-white table-th">STOCK</th>
                                <th class="text-center text-white table-th">INVENTARIO MÍNIMO</th>
                                <th class="text-center text-white table-th">IMAGEN</th>
                                <th class="text-center text-white table-th">ACCIÓN</th>
                            </tr>

                        </thead>

                        <tbody>
                            @foreach ($data as $product)
                                <tr>
                                    <td>
                                        <h6>{{ $product->name }}</h6>
                                    </td>
                                    <td class="text-center ">
                                        <h6>{{ $product->barcode }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $product->category }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>${{ number_format($product->cost) }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>${{ number_format($product->price) }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $product->stock }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $product->alert }}</h6>
                                    </td>

                                    <td class="text-center">
                                        @if($product->image != null)
                                        <span>
                                            <img src="{{ asset('storage/products/' .$product->image) }}"
                                            height="70" width="80" class="rounded" alt="no-image">
                                        </span>
                                            @else
                                            <img src="{{asset('img/noimage.jpg') }}"
                                            height="70" width="80" class="rounded" alt="no-image">

                                        @endif
                                    </td>
                                    <td class="text-center">
                                       <!--VALIDACION ACTUALIZAR PRODUCTO-->
                                        <a href="javascript:void(0)" wire:click.prevent="Edit({{ $product->id }})"
                                            class="btn btn-info mtmobile" tittle="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>


                                        <!--VALIDACION ELIMINAR PRODUCTO-->
                                        <a href="javascript:void(0)" class="btn btn-danger" tittle="Delete"
                                            onclick="confirm('{{ $product->id }}')">
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

    @include('livewire.products.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', msg => {
            $('#themodal').modal('show');
        });

        window.livewire.on('product-added', msg => {
            $('#themodal').modal('hide');
        });

        //listen row-updated event//
        window.livewire.on('product-updated', msg => {
            $('#themodal').modal('hide');
        });

        window.livewire.on('hide-modal', msg => {
            $('#themodal').modal('hide')
        })

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
                swal.fire(
                    'El Registro ha sido eliminado satisfactoriamente'

                )
            }
        })
    }
</script>
