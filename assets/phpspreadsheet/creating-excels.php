<?php
//require this page so i can use the WP functions
require_once '../../../../../wp-load.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

global $wpdb;

//getting all eligible winners
$sql = "SELECT * FROM (( users_details INNER JOIN winners ON users_details.id_user = winners.id_user ) 
INNER JOIN prizes ON winners.prize_id = prizes.id_prize ) WHERE choosed_prize='da' AND exported='nu';";
$sqlResults = $wpdb->get_results($sql, ARRAY_A);

//Styling
$tableHead = [
    'font' => [
        'color' => [
            'rgb' => 'FFFFFF'
        ],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '538ED5'
        ]
    ]
];

$evenRow = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '00BDFF'
        ]
    ]
];

$oddRow = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '00EAFF'
        ]
    ]
];
//

//Make a new spreadsheetobject
$spreadsheet = new Spreadsheet();

//get the current active sheet
$sheet = $spreadsheet->getActiveSheet();

//Set the default font
$spreadsheet->getDefaultStyle()
    ->getFont()
    ->setName('Calibri')
    ->setSize(14);

//heading
$spreadsheet->getActiveSheet()
    ->setCellValue('A1', 'Nume')
    ->setCellValue('B1', 'Prenume')
    ->setCellValue('C1', 'Telefon')
    ->setCellValue('D1', 'Email')
    ->setCellValue('E1', 'Județ')
    ->setCellValue('F1', 'Oraș')
    ->setCellValue('G1', 'Adresă')
    ->setCellValue('H1', 'ID Premiu')
    ->setCellValue('I1', 'Nume premiu');

//Creating the border
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(16)->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getBorders()->getDiagonal()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

//setting the width of the columns
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(17);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(17);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(23);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(55);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);

//background color
$spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($tableHead);

//loop through the data
$row = 2;
foreach ($sqlResults as $result) {
    $spreadsheet->getActiveSheet()
        ->setCellValue('A' . $row, $result['lastName'])
        ->setCellValue('B' . $row, $result['firstName'])
        ->setCellValue('C' . $row, $result['phone'])
        ->setCellValue('D' . $row, $result['email'])
        ->setCellValue('E' . $row, $result['county'])
        ->setCellValue('F' . $row, $result['city'])
        ->setCellValue('G' . $row, $result['address'])
        ->setCellValue('H' . $row, $result['prize_id'])
        ->setCellValue('I' . $row, $result['name_prize']);

    if ($row % 2 == 0) {
        $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':I' . $row)->applyFromArray($evenRow);
    } else {
        $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':I' . $row)->applyFromArray($oddRow);
    }
    ++$row;
}

//filter
$firstRow = 1;
$lastRow = $row - 1;
$spreadsheet->getActiveSheet()->setAutoFilter("A" . $firstRow . ':I' . $lastRow);

$writer = new Xlsx($spreadsheet);
$writer->save('../../Delivery Excels/NewTable.xlsx');

