<?php
/**
 * Created by JetBrains PhpStorm.
 * User: MIKE
 * Date: 2/27/16
 * Time: 2:02 PM
 * To change this template use File | Settings | File Templates.
 */

include dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';


class DAOExcelHotelGroup {

    public function loadFromExcel($fileName){

        $hotelGroupsFromExcel = array();
        $document = PHPExcel_IOFactory::load('uploads/'.$fileName);
        $activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);
        for($i=2; $i<7; $i++){
                // echo '<td>'.$activeSheetData[$i][$letter].'</td>';
                $hotelGroup = array('id' => $activeSheetData[$i]['A'], 'group_name'=>$activeSheetData[$i]['B']);
                $hotelGroupsFromExcel[]= $hotelGroup;

        }

        return $hotelGroupsFromExcel;

    }


    public function loadInfoFromExcel($fileName){
        $document = PHPExcel_IOFactory::load('uploads/'.$fileName);
        $activeSheetData = $document->getActiveSheet()->toArray(null, true, true, true);
        $everything = array();
        $letters = range('A', 'K');

        for($i=2; $i<7; $i++){
                $line = array();
                foreach($letters as $letter){
                    $line[] = $activeSheetData[$i][$letter];
                }
                $everything[] = $line;
        }

        return $everything;
    }
}