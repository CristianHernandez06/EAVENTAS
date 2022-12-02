<div class="row sales layout-top-spacing">
    <div class="col-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="text-center card-title"><b>{{ $componentName }}</b></h4>
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el usuario:</h6>
                                <div class="form-group">
                                    <select wire:model="userId" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte:</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ventas del día</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2 col-sm-12">
                                <h6>Fecha desde:</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateFrom" class="form-control flatpickr"
                                        placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="mt-2 col-sm-12">
                                <h6>Fecha hasta:</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateTo" class="form-control flatpickr"
                                        placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button class="btn btn-info btn-block" wire:click="$refresh">
                                    Consultar
                                </button>

                                <a class="btn btn-info btn-block {{count($data) < 1 ? 'disabled' : '' }}"
                                    href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/'
                                    . $dateTo) }}" target="_blank">Generar PDF</a>

                                <a class="btn btn-dark btn-block {{count($data) < 1 ? 'disabled' : '' }}"
                                    href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/'
                                     . $dateTo) }}" target="_blank">Exportar a Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">

                        {{-- Tabla --}}
                        <div class="table-responsive">
                            <table class="table mt-1 table-bordered table-striped">
                                <thead class="text-white" style="background: #000000">
                                    <tr>
                                        <th class="text-center text-white table-th">FOLIO</th>
                                        <th class="text-center text-white table-th">TOTAL</th>
                                        <th class="text-center text-white table-th">ITEMS</th>
                                        <th class="text-center text-white table-th">ESTATUS</th>
                                        <th class="text-center text-white table-th">USUARIO</th>
                                        <th class="text-center text-white table-th">FECHA</th>
                                        <th class="text-center text-white table-th" width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) < 1)
                                        <tr>
                                            <td colspan="7">
                                                <h5>Sin resultados</h5>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($data as $d)
                                            <tr>
                                                <td class="text-center">
                                                    <h6>{{ $d->id }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ number_format($d->total) }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $d->items }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $d->status }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $d->user }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>
                                                        {{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}
                                                    </h6>
                                                </td>
                                                <td class="text-center" width="50px">
                                                    <button wire:click.prevent="getDetails({{ $d->id }})"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reports.sales-detail')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            }
        })
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
        })
        window.livewire.on('error', msg => {
            noty(msg)
        });
    });
</script>
