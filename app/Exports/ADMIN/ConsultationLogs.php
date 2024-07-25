<?php

namespace App\Exports\ADMIN;


use Carbon;
use App\Patient;
use App\Consultation;
use DB;

use Maatwebsite\Excel\Concerns\FromCollection;


// use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;



use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;


Writer::macro('setCreator', function (Writer $writer, string $creator) {
    $writer->getDelegate()->getProperties()->setCreator($creator);
});

$GLOBALS['a'] = 0;
$GLOBALS['patient_id'] = [];

class ConsultationLogs implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$data = Consultation::ConsultationLogs();
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
                ->setCellValue('A1', 'DATE')
                ->setCellValue('B1', 'NO')
                ->setCellValue('C1', 'LAST NAME')
                ->setCellValue('D1', 'FIRST NAME')
                ->setCellValue('E1', 'MIDDLE NAME')
                ->setCellValue('F1', 'CITY/MUNICIPALITY')
                ->setCellValue('G1', 'PROVINCE')
                ->setCellValue('H1', 'DISTRICT')
                ->setCellValue('I1', 'AGE')
                ->setCellValue('J1', 'SEX')
                ->setCellValue('K1', 'DIAGNOSIS')
                ->setCellValue('L1', 'PHYSICIAN')
                ->setCellValue('M1', 'NEW')
                ->setCellValue('N1', 'OLD');
            }
        ];
    }
    
    public function map($data): array
    {
        if (in_array($data->patients_id, $GLOBALS['patient_id'])) {
            $new = '';
            $old = 'old';
        }else{
            array_push($GLOBALS['patient_id'], $data->patients_id);
            $new = 'new';
            $old = '';
        }
        return [
            Carbon::parse($data->date_consulted)->format('m/d/Y'),
            $GLOBALS['a'] +=1,
            $data->last_name,
            $data->first_name,
            $data->middle_name,
            $data->citymunDesc,
            $data->provDesc,
            $data->district,
            Patient::age($data->birthday),
            $data->sex,
            $data->description,
            $data->doctor,
            $new,
            $old,
        ];
    }
}
