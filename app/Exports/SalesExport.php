<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{

    protected $userId, $dateFrom, $dateTo, $reportType;

    public function __construct($userId, $reportType, $f1, $f2)
    {

        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
    }

    public function collection()
    {
        $data = [];

        if ($this->reportType == 0)
         {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';

        } else {
            $from = Carbon::parse($this->dateFrom)->locale('es')->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->locale('es')->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->userId == 0)
        {
            $data = Sale::join('users as u','u.id','sales.user_id')
            ->select('sales.id','sales.total','sales.items','sales.status','u.name as user','sales.created_at')
            ->whereBetween('sales.created_at',[$from, $to])
            ->get();
        } else
        {
            $data = Sale::join('users as u','u.id','sales.user_id')
            ->select('sales.id','sales.total','sales.items','sales.status','u.name as user','sales.created_at')
            ->whereBetween('sales.created_at',[$from, $to])
            ->where('sales.user_id',$this->userId)
            ->get();
        }


        return $data;
    }


    //cabeceras del reporte//
    public function headings(): array
    {
        return ["FOLIO", "IMPORTE", "ITEMS", "ESTATUS", "USUARIO", "FECHA"];
    }
    // numero de celda
    public function startCell(): string
    {
        return 'A2';
    }
    // estilo font bold
    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]],
        ];
    }
    //titutlo excel 'reporte de ventas'
    public function title(): string
    {
        return 'Reporte de Ventas';
    }
}
