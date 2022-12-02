<div class="mt-3 row">
    <div class="col-sm-12">
        <div class="connect-sorting">
            <h5 class="mb-2 text-center">DENOMINACIONES</h5>

            <div class="container">
                <div class="row">
                    @foreach ($denominations as $coin)
                        <div class="mt-2 col-sm">

                            <button wire:click.prevent="ACash({{$coin->value}})" class="btn btn-info btn-block den" >
                                {{ $coin->value > 0 ? '$' . number_format($coin->value,0, '.', '') : 'Exacto'}}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-4 connect-sorting-content">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="mb-3 input-group input-group-md">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gps hideonsm" style="backgroud: #000000; color:black">
                                    Efectivo F9
                                </span>
                            </div>
                            <input wire:model="efectivo"
                            wire:keydown.enter="saveSale"
                            class="text-center form-control" value="{{$efectivo}}"
                            type="number" name="cash" id="cash">
                            <div class="input-group-append">
                                <span wire:click="clearEfecty" class="input-group-text" style="background: #000000; color:white">
                                    <i class="fas fa-backspace fa-2x"></i>
                                </span>
                            </div>
                        </div>
                        <h4 class="text-muted" >Cambio: ${{number_format($change,2)}}</h4>

                        <div class="mt-1 row justify-content-between">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($total > 0)
                                    <button onclick="Confirm('','clearCart','¿Segur@ de limpiar la venta?')" class="btn btn-info mtmobile">
                                        CANCELAR F4
                                    </button>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($efectivo >= $total && $total > 0)
                                    <button wire:click.prevent="saveSale"
                                    class="btn btn-info btn-md btn-block">
                                        GUARDAR F8
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
