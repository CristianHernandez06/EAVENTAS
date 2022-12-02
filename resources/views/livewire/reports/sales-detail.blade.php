<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="text-center text-white modal-title">
          <b>Detalle de Venta #{{$saleId}}</b>
          </h5> 
          <h6 class="text-center text-warning" wire:loading>Por Favor Espere</h6>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table mt-1 table-bordered striped">


                <thead class="text-center text-white" style="background: #000000">

                <tr>
                    <th class="text-left text-white table-th">FOLIO</th>
                    <th class="text-left text-white table-th">PRODUCTO</th>
                    <th class="text-left text-white table-th">PRECIO</th>
                    <th class="text-left text-white table-th">CANT.</th>
                    <th class="text-left text-white table-th">IMPORTE</th>
                </tr>

                </thead>

                <tbody>
                    @foreach ($details as $d)
                        <tr>
                            <td><h6>{{$d->id}}</h6></td>
                            <td><h6>{{$d->product}}</h6></td>
                            <td><h6>{{number_format($d->price)}}</h6></td>
                            <td><h6>{{number_format($d->quantity,0)}}</h6></td>
                            <td><h6 >{{number_format($d->price * $d->quantity)}}</h6></td>

                        </tr>
                    @endforeach

                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="2"><h5 class="text-left font-weight-bold">Total: </h5></td>
                        <td colspan="2"><h5 class="text-left">{{$countDetails}}</h5></td>
                        <td colspan="2"><h5 class="text-left">${{number_format($sumDetails)}}</h5></td>
                    </tr>
                </tfoot>

                </table>

        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info close-btn text-info" data-dismiss="modal">Cerrar</button>

        </div>
      </div>
    </div>
  </div>
