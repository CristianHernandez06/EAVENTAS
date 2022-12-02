<div class="row">
    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">
                <h5 class="text-center mb-3">
                    RESUMEN DE VENTA
                </h5>
                <div class="connect-sorting-content">
                    <div class="card simple-title-task ui-sortable-handle">
                        <div class="card-body">
                            <div class="task-header">
                                <div>
                                    <h4>TOTAL: ${{ number_format($total) }}</h2>
                                    <input type="hidden" name="" id="hiddenTotal" value="{{$total}}">
                                </div>
                                <div>
                                    <h4 class="mt-2">Cant. Articulos: {{$ItemsQuantity}}</h4>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>