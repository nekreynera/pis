<?php

namespace App\Exports;

use DB;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

use \Maatwebsite\Excel\Sheet;
use \Maatwebsite\Excel\Writer;

use PhpOffice\PhpSpreadsheet\IOFactory;

use Auth;
use Carbon;


Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});


Writer::macro('setCreator', function (Writer $writer, string $creator) {
    $writer->getDelegate()->getProperties()->setCreator($creator);
});

class CashierExport implements FromCollection, WithEvents, WithColumnFormatting, WithMapping, WithCustomStartCell
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      $cshier_id = Auth::user()->id;
      if ($cshier_id == 150 || $cshier_id == 325) {
        $cshier_id = '150,325';
      }
      elseif ($cshier_id == 269 || $cshier_id == 259 || $cshier_id == 145) {
        $cshier_id = '269,259,145';
      }
      elseif ($cshier_id == 366 || $cshier_id == 320) {
        $cshier_id = '366,320';
      }
      $data = collect(DB::select("SELECT DATE(h.created_at) as dates, 
                                      h.or_no as numbers,
                                      i.last_name, i.first_name, i.middle_name,
                                      (CASE 
                                        WHEN h.void = 1
                                        THEN 'CANCELLED'
                                        ELSE 'HOSPITAL ID'
                                      END) as particulars,
                                      (CASE 
                                        WHEN h.void = 1
                                        THEN '0.00'
                                        ELSE h.price
                                      END) as total,
                                      (CASE 
                                        WHEN h.void = 1
                                        THEN '0.00'
                                        ELSE h.price
                                      END) as other,
                                      (' ') as medical,
                                      (' ') as laboratory,
                                      (' ') as radiology,
                                      (' ') as cardiology,
                                      (' ') as supply
                                  FROM cashidsale h
                                  LEFT JOIN patients i ON h.patients_id = i.id
                                  LEFT JOIN users j ON h.users_id = j.id
                                  WHERE date(h.created_at) = ?
                                  AND h.users_id IN($cshier_id)
                                  GROUP BY h.or_no
                                  UNION
                                  SELECT DATE(o.created_at) as dates,
                                      o.or_no as numbers,
                                      p.last_name, p.first_name, p.middle_name,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN t.id IN(6,11,13)
                                              THEN s.sub_category
                                              WHEN s.type
                                              THEN s.sub_category
                                              ELSE t.category
                                          END)
                                        ELSE 'CANCELLED'
                                      END) as particulars,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN o.discount 
                                              THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                              ELSE SUM(((o.qty * o.price) - 0) - COALESCE(pg.granted_amount, 0 ))
                                           END)
                                        ELSE ''
                                      END) as total,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN t.id IN(1, 2, 3, 4, 5, 7, 8, 13, 14, 15, 17, 18, 19)
                                              AND s.type = 0
                                              THEN (CASE 
                                                      WHEN o.discount 
                                                      THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                                      ELSE SUM(((o.qty * o.price) - 0) - COALESCE(pg.granted_amount, 0 ))
                                                    END) 
                                              ELSE  ' '
                                          END)
                                        ELSE ''
                                      END) as other,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN t.id IN(9) 
                                              AND s.type = 0
                                              THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                              ELSE ' '
                                          END)
                                        ELSE ''
                                      END) as medical,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN t.id = 10 
                                              AND s.type = 0
                                              THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                              ELSE ' '
                                           END)
                                        ELSE ''
                                      END) as laboratory,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN t.id IN(6,11) 
                                              AND s.type = 0
                                              THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                              ELSE ' '
                                           END) 
                                        ELSE ''
                                      END) as radiology,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN t.id IN(12) 
                                              AND s.type = 0
                                              THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                              ELSE ' '
                                           END)
                                        ELSE ''
                                      END) as cardiology,
                                      (CASE 
                                        WHEN o.void = '0'
                                        THEN 
                                          (CASE 
                                              WHEN s.type = 1
                                              THEN SUM(((o.qty * o.price) - o.discount) - COALESCE(pg.granted_amount, 0 ))
                                              ELSE ' '
                                           END)
                                        ELSE ''
                                      END) as supply
                                  FROM cashincome o
                                  LEFT JOIN patients p ON o.patients_id = p.id
                                  LEFT JOIN mss q ON o.mss_id = q.id
                                  LEFT JOIN users r ON o.users_id = r.id
                                  LEFT JOIN cashincomesubcategory s ON o.category_id = s.id
                                  LEFT JOIN cashincomecategory t ON s.cashincomecategory_id = t.id
                                  -- LEFT JOIN payment_guarantor pg ON o.id = pg.payment_id AND pg.type = 0
                                  LEFT JOIN 
                                    (SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 0 GROUP BY payment_id) pg 
                                  ON o.id = pg.payment_id
                                  WHERE date(o.created_at) = ?
                                              AND o.users_id IN($cshier_id)
                                              GROUP BY o.or_no, t.id
                                  UNION
                                  SELECT 
                                      DATE(u.created_at) as dates,
                                      u.or_no as numbers,
                                      x.last_name, x.first_name, x.middle_name,
                                      (CASE 
                                        WHEN u.void = 0
                                        THEN 'LABORATORY'
                                        ELSE 'CANCELLED'
                                      END) as particulars,
                                      (CASE 
                                        WHEN u.void = 0
                                        THEN (SUM(((v.qty * u.price) - u.discount) - COALESCE(pgu.granted_amount, 0 )))
                                        ELSE ''
                                      END) as total,
                                      ('') as other,
                                      ('') as medical,
                                      (CASE 
                                        WHEN u.void = 0
                                        THEN (SUM(((v.qty * u.price) - u.discount) - COALESCE(pgu.granted_amount, 0 )))
                                        ELSE ''
                                      END) as laboratory,
                                      ('') as radiology,
                                      ('') as cardiology,
                                      ('') as supply
                                  FROM laboratory_payment u
                                  LEFT JOIN laboratory_requests v ON u.laboratory_request_id = v.id
                                  LEFT JOIN laboratory_request_groups w ON v.laboratory_request_group_id = w.id
                                  LEFT JOIN patients x ON w.patient_id = x.id
                                  LEFT JOIN laboratory_sub_list y ON v.item_id = y.id
                                  -- LEFT JOIN payment_guarantor pgu ON u.id = pgu.payment_id AND pgu.type = 1
                                  LEFT JOIN 
                                    (SELECT payment_id, SUM(granted_amount) as granted_amount FROM payment_guarantor WHERE type = 1 GROUP BY payment_id) pgu 
                                  ON u.id = pgu.payment_id
                                  WHERE DATE(u.created_at) = ?
                                  AND u.user_id IN($cshier_id)
                                  GROUP BY u.or_no
                                  ORDER BY numbers ASC
                                          ", [
                                                old('transdate'), 
                                                old('transdate'),
                                                old('transdate')
                                              ]));
    return $data;
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


                $data = $event->sheet->getDelegate()->getHighestRow() + 1;
                 
                /*=====PAGE SETUP=======*/
                  // DATA START TO PRINT
                  $event->sheet->getDelegate()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(6,8);
                  // PAGE LAYOUT
                  $event->sheet->getDelegate()->getPageSetup()
                  ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                  ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                  $event->sheet->getDelegate()->getPageSetup()->setFitToWidth(1)
                  ->setFitToHeight(0)
                  ->setHorizontalCentered(true)
                  ->setVerticalCentered(false);
                  $event->sheet->getDelegate()->getPageMargins()->setTop(0.5)
                  ->setRight(0.5)
                  ->setLeft(0.5)
                  ->setBottom(0.5);

                  // PAGE FOOTER
                  $event->sheet->getDelegate()->getHeaderFooter()
                  ->setOddFooter('&B&RPage &P of &N');

                  // TAB 
                  $event->sheet->getDelegate()->getTabColor()->setRGB('FF0000');



                /*=====PAGE STYLE======*/

                $styleArray1 = [
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '4d4d4d'],
                                    ],
                                ],
                              ];
                $event->sheet->getDelegate()->getStyle('A6:M'.$data.'')->applyFromArray($styleArray1);


                $styleArray2 = [
                                'font' => [
                                  'bold' => true,
                                ],
                              ];

                $event->sheet->getDelegate()->getStyle('A6:M8')->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('C3')->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('A5')->applyFromArray($styleArray2);
                // $event->sheet->getDelegate()->getStyle('G'.$data.':L'.$data.'')->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('H'.($data+4).'')->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('B'.($data+17).':G'.($data+17).'')->applyFromArray($styleArray2);
                $event->sheet->getDelegate()->getStyle('B'.($data+12))->applyFromArray($styleArray2);

                $styleArray3 = [
                                'borders' => [
                                    'bottom' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '4d4d4d'],
                                    ],
                                ],
                              ];
                $event->sheet->getDelegate()->getStyle('C3:D3')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('C4:D4')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('H3')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('H4')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('H5')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('H'.($data+3).'')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('H'.($data+7).'')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('A'.($data+9).':M'.($data+9).'')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('A'.($data+10).':M'.($data+10).'')->applyFromArray($styleArray3);
                $event->sheet->getDelegate()->getStyle('A'.($data+22).':M'.($data+22).'')->applyFromArray($styleArray3);


                /*=====MERGE CELL======*/
                $event->sheet->getDelegate()
                ->mergeCells('A'.($data+10).':L'.($data+10).'')
                ->mergeCells('B'.($data+17).':D'.($data+17).'')
                ->mergeCells('B'.($data+18).':D'.($data+18).'')
                ->mergeCells('B'.($data+19).':D'.($data+19).'')
                ->mergeCells('B'.($data+20).':D'.($data+20).'')
                ->mergeCells('B'.($data+21).':D'.($data+21).'')
                ->mergeCells('B'.($data+22).':D'.($data+22).'')
                ->mergeCells('G'.($data+17).':I'.($data+17).'')
                ->mergeCells('G'.($data+18).':I'.($data+18).'')
                ->mergeCells('G'.($data+19).':I'.($data+19).'')
                ->mergeCells('G'.($data+20).':I'.($data+20).'')
                ->mergeCells('G'.($data+21).':I'.($data+21).'')
                ->mergeCells('G'.($data+22).':I'.($data+22).'')
                ->mergeCells('B'.($data+12).':C'.($data+12))
                ->mergeCells('A1:L1')
                ->mergeCells('A6:B7')
                ->mergeCells('C6:C8')
                ->mergeCells('D6:D8')
                ->mergeCells('E6:E8')
                ->mergeCells('F6:F8')
                ->mergeCells('G6:M6')
                ->mergeCells('G7:G8')
                ->mergeCells('H7:H8')
                ->mergeCells('I7:I8')
                ->mergeCells('J7:J8')
                ->mergeCells('K7:K8')
                ->mergeCells('L7:L8')
                ->mergeCells('M7:M8');


                /*======WIDTH CELL======*/
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(12);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(13);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(13);

                /*======HIGHT CELL======*/
                $event->sheet->getDelegate()->getRowDimension('7')->setRowHeight(55);

                /*======FONT HEIGHT======*/
                $event->sheet->getDelegate()->getStyle('A6')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('A6')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('C6')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('H7')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('I7')->getFont()->setSize(8);
                $event->sheet->getDelegate()->getStyle('F6')->getFont()->setSize(8);
                
                /*=====CONTENT CELL=====*/
                $event->sheet->getDelegate()
                ->setCellValue('A1', 'REPORT OF COLLECTIONS AND DEPOSITS')
                ->setCellValue('A3', 'Entitty Name:')
                ->setCellValue('A4', 'Fund:')
                ->setCellValue('A5', 'HOSPITAL INCOME (LBP)')
                // ->setCellValue('C2', 'EASTERN VISAYAS REGIONAL MEDICAL CENTER')
                ->setCellValue('F3', 'Report No.')
                ->setCellValue('F4', 'Sheet No')
                ->setCellValue('F5', 'Date:')
                ->setCellValue('A6', "Official Receipt/\nReport of Collectionsby\nSub-Collector")
                ->setCellValue('A8', "DATE")
                ->setCellValue('B8', "NUMBER")
                ->setCellValue('C6', "Responsibilty\nCenter\nCode")
                ->setCellValue('D6', "Payor")
                ->setCellValue('E6', "Particulars")
                ->setCellValue('F6', "MFO/PAP")
                ->setCellValue('G7', "TOTAL\nPER\nOR")
                ->setCellValue('H7', "OTHER\nFEES\n(4020217099)")
                ->setCellValue('I7', "MEDICAL FEES\n- PHYSICAL\nMEDICINE &\nREHABILITATION\nSERVICES\n(4020217009)")
                ->setCellValue('J7', "LABORATORY")
                ->setCellValue('K7', "RADIOLOGY")
                ->setCellValue('L7', "CARDIOLOGY")
                ->setCellValue('M7', "SUPPLIES")
                ->setCellValue('G6', "AMOUNT")
                ->setCellValue('H3', old('mreportno'))
                ->setCellValue('H5', Carbon::parse(old('transdate'))->format('M. d, Y'))
                ->setCellValue('B'.($data+1).'', 'Summary')
                ->setCellValue('B'.($data+2).'', 'Undeposited Collections per last Report')
                ->setCellValue('H'.($data+2).'', number_format(old('undeposited'), 2, '.', ''))
                ->setCellValue('B'.($data+3).'', 'Collections per OR Nos.') 
                ->setCellValue('H'.($data+3).'', '=G'.$data.'') 
                ->setCellValue('H'.($data+4).'', '=SUM(H'.($data+2).':H'.($data+3).')') 
                ->setCellValue('C'.($data+5).'', 'Deposits')
                ->setCellValue('D'.($data+5).'', old('mgstart'))
                ->setCellValue('C'.($data+7).'', 'Date:')
                ->setCellValue('H'.($data+7).'', '=H'.($data+2))
                ->setCellValue('D'.($data+7).'',  Carbon::parse(old('transdate'))->format('M. d, Y'))
                ->setCellValue('B'.($data+8).'', 'Undeposited Collections, this Report')
                ->setCellValue('A'.($data+10).'', 'CERTIFICATION')
                ->setCellValue('H'.($data+8).'', '=G'.$data.'')
                ->setCellValue('B'.($data+11).'', 'I hereby certify on my official oath that the above is a true statement of all collections and deposits had by me during the period stated above which Official')
                ->setCellValue('A'.($data+12).'', 'Receipts Nos.')
                ->setCellValue('B'.($data+12).'', $event->sheet->getDelegate()->getCellByColumnAndRow(2, 9)->getValue().'-'.$event->sheet->getDelegate()->getCellByColumnAndRow(2, ($data-1))->getValue())
                ->setCellValue('D'.($data+12).'', 'inclusive were actually issued by me in the amounts shown thereon. I also certify that I have not received money from whatever')
                ->setCellValue('A'.($data+13).'', 'source without having issued the necessary Official Receipt in acknowledgement thereof. Collections received by sub-collectors are recorded above in lump-sum')
                ->setCellValue('A'.($data+14).'', 'opposite their respective collector report numbers. I certify further that the balance shown above agrees with the balance appearing in my Cash Receipts Record.')
                ->setCellValue('B'.($data+16).'', 'Prepared by:')
                ->setCellValue('G'.($data+16).'', 'Reviewed by:')
                ->setCellValue('C'.($data+17).'', ''.Auth::user()->first_name.' '.substr(Auth::user()->middle_name, 0,1).'. '.Auth::user()->last_name.'.')
                ->setCellValue('B'.($data+17).'', '=UPPER(C'.($data+17).')')
                ->setCellValue('G'.($data+17).'', 'RUFINA G. AGNER')
                ->setCellValue('B'.($data+18).'', 'Name and Signature of the Collecting Officer')
                ->setCellValue('G'.($data+18).'', 'Supervising Administrative Officer')
                ->setCellValue('B'.($data+19).'', old('msdisignation'))
                ->setCellValue('B'.($data+20).'', 'Official Designation')
                ->setCellValue('B'.($data+22).'', 'Date');

                /*=====VALUE AUTO SUM===*/
                $event->sheet->getDelegate()->setCellValue('G'.$data.'', '=SUM(G9:G'.($data-1).')');
                $event->sheet->getDelegate()->setCellValue('H'.$data.'', '=SUM(H9:H'.($data-1).')');
                $event->sheet->getDelegate()->setCellValue('I'.$data.'', '=SUM(I9:I'.($data-1).')');
                $event->sheet->getDelegate()->setCellValue('J'.$data.'', '=SUM(J9:J'.($data-1).')');
                $event->sheet->getDelegate()->setCellValue('K'.$data.'', '=SUM(K9:K'.($data-1).')');
                $event->sheet->getDelegate()->setCellValue('L'.$data.'', '=SUM(L9:L'.($data-1).')');
                $event->sheet->getDelegate()->setCellValue('M'.$data.'', '=SUM(M9:M'.($data-1).')');

                /*=====CELL FORMAT=====*/
                $event->sheet->getDelegate()->getStyle('G'.$data.':M'.$data)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->getDelegate()->getStyle('H'.($data+1).':H'.($data+8))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                /*=====CELL ALIGNMENT====*/
                $event->sheet->getDelegate()->getStyle('A6:M8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A9:B'.$data.'')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A'.($data+10).'')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('B'.($data+17).':B'.($data+22).'')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G'.($data+17).':G'.($data+22).'')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('B'.($data+12))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A6:M8')->getAlignment()->setWrapText(true);

            },
        ];
    }

    public function map($data): array
        {
            return [
                Date::dateTimeToExcel(\DateTime::createFromFormat('Y-m-d', $data->dates)),
                $data->numbers,
                '',
                $data->last_name.', '.$data->first_name.' '.substr($data->middle_name, 0,1).'.',
                strtoupper($data->particulars),
                '',
                $data->total,
                $data->other,
                $data->medical,
                $data->laboratory,
                $data->radiology,
                $data->cardiology,
                $data->supply,
            ];
        }


    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
    public function startCell(): string
    {
      return 'A9';
      

    }
}
