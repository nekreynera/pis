<?php

namespace App\Exports\Laboratory;

use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

use App\LaboratoryQueues;
use Carbon;

use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


Writer::macro('setCreator', function (Writer $writer, string $creator) {
    $writer->getDelegate()->getProperties()->setCreator($creator);
});



class PatientExport implements FromCollection, ShouldAutoSize, WithCustomStartCell, WithEvents, WithMapping, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $data =  LaboratoryQueues::export();
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
                ->setCellValue('A1', 'HOSPITAL NO')
                ->setCellValue('B1', 'LAST NAME')
                ->setCellValue('C1', 'FIRST NAME')
                ->setCellValue('D1', 'MIDDLE NAME')
                ->setCellValue('E1', 'BIRTHDAY')
                ->setCellValue('F1', 'GENDER')
                ->setCellValue('G1', 'CIVIL STATUS')
                ->setCellValue('H1', 'DATETIME REGISTERED')
                ->setCellValue('I1', 'DATETIME QUEUED');
            }
        ];
    }
    public function map($data): array
    {
        return [
            $data->hospital_no,
            $data->last_name,
            $data->first_name,
            $data->middle_name,
            $data->birthday,
            $data->sex,
            $data->civil_status,
            $data->created_at,
            $data->datetime_queued,
           
        ];
    }
    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            // 'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            // 'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            // 'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            // 'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            // 'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            // 'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
