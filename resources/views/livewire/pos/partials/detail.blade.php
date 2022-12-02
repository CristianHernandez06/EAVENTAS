<div class="connect-sorting">

        <div class="connect-sorting-content">

            <div class="card simple-title-task ui-sortable-handle">

                <div class="card-body">
                    @if($total > 0 )
                    <div class="table-responsive tblscroll" style="max-height: 650px; overflow:hidden">

                        <table class="table mt-1 table-bordered table-striped">

                        <thead class="text-white" style="background: #000000">
                            <th with="10%"></th>
                            <th class="text-left text-white table-th">DESCRIPCIÓN</th>
                            <th class="text-center text-white table-th">PRECIO</th>
                            <th  whith="13%" class="text-center text-white table-th">CANTIDAD  </th>
                            <th class="text-center text-white table-th">IMPORTE</th>
                            <th class="text-center text-white table-th">ACCIONES</th>
                            </thead>
                        <tbody>

                        @foreach($cart as $item)
                            <tr>
                                <td class="text-center table-th">
                                    @if(count($item->attributes)>0)
                                    <span>
                                       <img src="{{asset('storage/products/' . $item->attributes[0])}}" alt="imagen de producto" height="90" width="90" class="rounded" >
                                    </span>
                                    @endif
                                </td>
                                <td><h6>{{$item->name}}</h6></td>
                                <td class="text-center">${{number_format($item->price,0)}}</td>
                                <td>
                                <input type="number" id="r{{$item->id}}"
                                wire:chage="updateQty({{$item->id}}, $('#r' + {{$item->id}}).val())"
                                style="font-size: 1rem!important"
                                class="text-center form-control"
                                value="{{$item->quantity}}"
                                >
                                </td>
                                <td class="text-center"><h6>
                                {{number_format($item->price * $item->quantity,0)}}
                                </h6></td>
                                <td class="text-center">
                                <!--primer boton (Eliminar Producto)-->
                                <button onclick="Confirm('{{$item->id}}','removeItem', '¿Confirmas Eliminar el Registro?')" class="btn btn-danger mbmobile">
                                <i class="fas fa-trash-alt"></i>
                                </button>

                                <!--segundo boton (reducir cant. producto)-->
                                <button wire:click.prevent="decreaseQty({{$item->id}})" class="btn btn-info mbmobile">
                                <i class="fas fa-minus"></i>
                                </button>

                                <!--tercer boton (aumentar cant. producto)-->
                                <button wire:click.prevent="increaseQty({{$item->id}})" class="btn btn-info mbmobile">
                                <i class="fas fa-plus"></i>
                                </button>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                        </table>

                    </div >
                    @else
                        <h5 class="text-center text-muted">Agrega Productos a la venta</h5>
                    @endif

                    <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-center text-danger">Guardando Venta...</h4>

                    </div>


                </div>


            </div>

        </div>

</div>
