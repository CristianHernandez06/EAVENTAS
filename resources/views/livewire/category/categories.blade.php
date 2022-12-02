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


                        <thead class="text-white" style="background:#000000">

                            <tr>
                                <th class="text-center text-white table-th">DESCRIPCIÓNES</th>
                                <th class="text-center text-white table-th">IMAGEN</th>
                                <th class="text-center text-white table-th">PRODUCTOS EN STOCK</th>
                                <th class="text-center text-white table-th">ACCIÓN</th>
                            </tr>

                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <h6>{{ $category->name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        @if ($category->image != null)
                                            <span>
                                                <img src="{{ asset('storage/categories/' . $category->image) }}"
                                                    height="70" width="80" class="rounded" alt="no-image">
                                            </span>
                                        @else
                                            <img src="{{ asset('images/noimage.jpg') }}" height="70" width="80"
                                                class="rounded" alt="no-image">

                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $category->products->count() }}</h6>
                                    </td>
                                    <td class="text-center">

                                        <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                            class="btn btn-info mtmobile" tittle="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>



                                        <a href="javascript:void(0)" class="btn btn-danger" tittle="Delete"
                                            onclick="confirm('{{ $category->id }}', '{{ $category->products->count() }}')">
                                            <i class="fas fa-trash"></i>
                                        </a>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('livewire.category.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-modal', Msg => {
            $('#themodal').modal('show');
        });

        window.livewire.on('category-added', Msg => {
            $('#themodal').modal('hide');
            notify(Msg)
        });

        //listen row-updated event
        window.livewire.on('category-updated', Msg => {
            $('#themodal').modal('hide')

        });

        window.livewire.on('hide-modal', Msg => {
            $('#themodal').modal('hide')
        })

    });


    function confirm(id, products) {
        if (products > 0) {
            swal('No se puede eliminar la categoria porque tiene productos relacionados')
            return;
        }


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
