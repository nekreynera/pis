<?php

namespace App\Exports\Laboratory;

use App\LaboratoryPayment;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

use Carbon;
use App\Patient;

use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;


Writer::macro('setCreator', function (Writer $writer, string $creator) {
    $writer->getDelegate()->getProperties()->setCreator($creator);
});

class MssDExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data =  LaboratoryPayment::getallmssclassifiedinD();
        return $data;

    }
    public function startCell(): string
    {
     	return 'A2';
    }
    public function registerEvents(): array
    {
    	return [
            /*======================================TABLE HEADER STYLE AND CONTENT=========================================*/
            BeforeExport::class  => function(BeforeExport $event) {
                /*=======CREATOR========*/
                            $event->writer->setCreator('Darryl Joseph A. Bagares');
                             
            },
            AfterSheet::class    => function(AfterSheet $event) {


            	$event->sheet->getDelegate()
                ->setCellValue('A1', 'CLASSIFICATION & OR#')
                ->setCellValue('B1', 'NAME OF PATIENT')
                ->setCellValue('C1', 'AGE')
                ->setCellValue('D1', 'ADDRESS')
                ->setCellValue('E1', 'PARTICULAR')
                ->setCellValue('F1', 'TOTAL AMT.')
                ->setCellValue('G1', 'AMT. PAID')
                ->setCellValue('H1', 'AMT. DSCNT');
            }
        ];
    }
    public function map($data): array
    {
        return [
            $data->classification,
            $data->patient,
            $data->age,
            $data->address,
            $data->name,
            $data->amount,
            $data->amount_paid,
            $data->amount_discount,
           
        ];
    }
}
